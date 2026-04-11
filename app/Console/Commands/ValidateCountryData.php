<?php

namespace App\Console\Commands;

use App\Models\Country;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class ValidateCountryData extends Command
{
    protected $signature = 'countries:validate {--fix : Actually update the database (dry-run by default)}';

    protected $description = 'Validate and fix country data (currency, EU membership, VIES) using REST Countries API';

    /**
     * Authoritative list of EU member state ISO 3166-1 alpha-2 codes (as of 2026).
     */
    private const EU_MEMBERS = [
        'AT', 'BE', 'BG', 'HR', 'CY', 'CZ', 'DK', 'EE', 'FI', 'FR',
        'DE', 'GR', 'HU', 'IE', 'IT', 'LV', 'LT', 'LU', 'MT', 'NL',
        'PL', 'PT', 'RO', 'SK', 'SI', 'ES', 'SE',
    ];

    /**
     * VIES (VAT Information Exchange System) is available for EU member states.
     * Northern Ireland (XI) also participates but we track countries by their main code.
     */
    private const VIES_COUNTRIES = self::EU_MEMBERS;

    /**
     * Authoritative VAT number format patterns per country.
     * Source: European Commission / national tax authorities.
     */
    private const VAT_NUMBER_FORMATS = [
        'AT' => 'ATU99999999',
        'BE' => 'BE0999999999',
        'BG' => 'BG999999999 or BG9999999999',
        'HR' => 'HR99999999999',
        'CY' => 'CY99999999L',
        'CZ' => 'CZ99999999 to CZ9999999999',
        'DK' => 'DK99999999',
        'EE' => 'EE999999999',
        'FI' => 'FI99999999',
        'FR' => 'FRXX999999999',
        'DE' => 'DE999999999',
        'GR' => 'EL999999999',
        'HU' => 'HU99999999',
        'IE' => 'IE9S99999L or IE9999999WI',
        'IT' => 'IT99999999999',
        'LV' => 'LV99999999999',
        'LT' => 'LT999999999 or LT999999999999',
        'LU' => 'LU99999999',
        'MT' => 'MT99999999',
        'NL' => 'NL999999999B99',
        'PL' => 'PL9999999999',
        'PT' => 'PT999999999',
        'RO' => 'RO99 to RO9999999999',
        'SK' => 'SK9999999999',
        'SI' => 'SI99999999',
        'ES' => 'ESX9999999X',
        'SE' => 'SE999999999999',
        // Non-EU countries
        'GB' => 'GB999999999 or GBGD999 or GBHA999',
        'CH' => 'CHE-999.999.999',
        'NO' => 'NO999999999MVA',
        'IS' => 'IS99999 or IS999999',
        'TR' => 'TR9999999999',
    ];

    public function handle(): int
    {
        $dryRun = ! $this->option('fix');

        if ($dryRun) {
            $this->warn('DRY RUN — no changes will be made. Use --fix to apply changes.');
        }

        $countries = Country::all();
        $this->info("Found {$countries->count()} countries to validate.");
        $this->newLine();

        // Fetch currency data from REST Countries API
        $this->info('Fetching currency data from REST Countries API...');
        $apiData = $this->fetchRestCountriesData($countries);

        $issues = [];
        $fixes = [];

        foreach ($countries as $country) {
            $iso = $country->iso_code;
            $countryIssues = [];
            $countryFixes = [];

            // 1. Validate EU membership
            $shouldBeEu = in_array($iso, self::EU_MEMBERS, true);
            if ((bool) $country->is_eu_member !== $shouldBeEu) {
                $countryIssues[] = "EU Member: {$this->boolLabel($country->is_eu_member)} → should be {$this->boolLabel($shouldBeEu)}";
                $countryFixes['is_eu_member'] = $shouldBeEu;
            }

            // 2. Validate VIES availability
            $shouldHaveVies = in_array($iso, self::VIES_COUNTRIES, true);
            if ((bool) $country->vies_available !== $shouldHaveVies) {
                $countryIssues[] = "VIES: {$this->boolLabel($country->vies_available)} → should be {$this->boolLabel($shouldHaveVies)}";
                $countryFixes['vies_available'] = $shouldHaveVies;
            }

            // 3. Validate currency from API data
            if (isset($apiData[$iso])) {
                $api = $apiData[$iso];

                if (! empty($api['currency_code']) && $country->currency_code !== $api['currency_code']) {
                    $countryIssues[] = "Currency Code: '{$country->currency_code}' → should be '{$api['currency_code']}'";
                    $countryFixes['currency_code'] = $api['currency_code'];
                }

                if (! empty($api['currency_name']) && $country->currency !== $api['currency_name']) {
                    $countryIssues[] = "Currency: '{$country->currency}' → should be '{$api['currency_name']}'";
                    $countryFixes['currency'] = $api['currency_name'];
                }

                if (! empty($api['currency_symbol']) && $country->currency_symbol !== $api['currency_symbol']) {
                    $countryIssues[] = "Currency Symbol: '{$country->currency_symbol}' → should be '{$api['currency_symbol']}'";
                    $countryFixes['currency_symbol'] = $api['currency_symbol'];
                }
            }

            if (! empty($countryIssues)) {
                $issues[$country->name] = $countryIssues;
                $fixes[$country->id] = $countryFixes;

                $this->line("<comment>{$country->name} ({$iso}):</comment>");
                foreach ($countryIssues as $issue) {
                    $this->line("  ✗ {$issue}");
                }
            }
        }

        $this->newLine();

        if (empty($issues)) {
            $this->info('All country data is correct!');

            return self::SUCCESS;
        }

        $this->warn(count($issues) . ' countries have data issues.');
        $this->newLine();

        if ($dryRun) {
            $this->warn('Run with --fix to apply these corrections.');

            return self::SUCCESS;
        }

        // Apply fixes
        $this->info('Applying fixes...');
        $fixed = 0;

        foreach ($fixes as $countryId => $data) {
            Country::where('id', $countryId)->update($data);
            $fixed++;
        }

        $this->info("Fixed {$fixed} countries.");
        $this->newLine();

        // Print summary table
        $this->printSummaryTable();

        return self::SUCCESS;
    }

    /**
     * Fetch currency data from REST Countries API for all countries.
     */
    private function fetchRestCountriesData($countries): array
    {
        $data = [];
        $codes = $countries->pluck('iso_code')->filter()->implode(',');

        try {
            $response = Http::timeout(15)
                ->get("https://restcountries.com/v3.1/alpha", [
                    'codes' => $codes,
                    'fields' => 'cca2,currencies',
                ]);

            if ($response->successful()) {
                $fallbackForLookup = $this->getFallbackCurrencyData();
                foreach ($response->json() as $item) {
                    $cca2 = $item['cca2'] ?? null;
                    if (! $cca2 || empty($item['currencies'])) {
                        continue;
                    }

                    // When API returns multiple currencies, prefer canonical from fallback
                    $currencies = array_keys($item['currencies']);
                    if (count($currencies) > 1 && isset($fallbackForLookup[$cca2])) {
                        $currencyCode = $fallbackForLookup[$cca2]['currency_code'];
                    } else {
                        $currencyCode = $currencies[0];
                    }

                    $currencyInfo = $item['currencies'][$currencyCode]
                        ?? $item['currencies'][array_key_first($item['currencies'])];

                    $data[$cca2] = [
                        'currency_code' => $currencyCode,
                        'currency_name' => $currencyInfo['name'] ?? null,
                        'currency_symbol' => $currencyInfo['symbol'] ?? null,
                    ];
                }

                $this->info("  Fetched data for " . count($data) . " countries from API.");
            } else {
                $this->error("  API request failed with status {$response->status()}. Using fallback data.");
                $data = $this->getFallbackCurrencyData();
            }
        } catch (\Exception $e) {
            $this->error("  API error: {$e->getMessage()}. Using fallback data.");
            $data = $this->getFallbackCurrencyData();
        }

        // Merge with fallback to ensure completeness
        $fallback = $this->getFallbackCurrencyData();
        foreach ($fallback as $code => $fallbackData) {
            if (! isset($data[$code])) {
                $data[$code] = $fallbackData;
            }
        }

        return $data;
    }

    /**
     * Fallback currency data in case API is unavailable.
     */
    private function getFallbackCurrencyData(): array
    {
        return [
            'AT' => ['currency_code' => 'EUR', 'currency_name' => 'Euro', 'currency_symbol' => '€'],
            'BE' => ['currency_code' => 'EUR', 'currency_name' => 'Euro', 'currency_symbol' => '€'],
            'BG' => ['currency_code' => 'BGN', 'currency_name' => 'Bulgarian lev', 'currency_symbol' => 'лв'],
            'HR' => ['currency_code' => 'EUR', 'currency_name' => 'Euro', 'currency_symbol' => '€'],
            'CY' => ['currency_code' => 'EUR', 'currency_name' => 'Euro', 'currency_symbol' => '€'],
            'CZ' => ['currency_code' => 'CZK', 'currency_name' => 'Czech koruna', 'currency_symbol' => 'Kč'],
            'DK' => ['currency_code' => 'DKK', 'currency_name' => 'Danish krone', 'currency_symbol' => 'kr'],
            'EE' => ['currency_code' => 'EUR', 'currency_name' => 'Euro', 'currency_symbol' => '€'],
            'FI' => ['currency_code' => 'EUR', 'currency_name' => 'Euro', 'currency_symbol' => '€'],
            'FR' => ['currency_code' => 'EUR', 'currency_name' => 'Euro', 'currency_symbol' => '€'],
            'DE' => ['currency_code' => 'EUR', 'currency_name' => 'Euro', 'currency_symbol' => '€'],
            'GR' => ['currency_code' => 'EUR', 'currency_name' => 'Euro', 'currency_symbol' => '€'],
            'HU' => ['currency_code' => 'HUF', 'currency_name' => 'Hungarian forint', 'currency_symbol' => 'Ft'],
            'IE' => ['currency_code' => 'EUR', 'currency_name' => 'Euro', 'currency_symbol' => '€'],
            'IT' => ['currency_code' => 'EUR', 'currency_name' => 'Euro', 'currency_symbol' => '€'],
            'LV' => ['currency_code' => 'EUR', 'currency_name' => 'Euro', 'currency_symbol' => '€'],
            'LT' => ['currency_code' => 'EUR', 'currency_name' => 'Euro', 'currency_symbol' => '€'],
            'LU' => ['currency_code' => 'EUR', 'currency_name' => 'Euro', 'currency_symbol' => '€'],
            'MT' => ['currency_code' => 'EUR', 'currency_name' => 'Euro', 'currency_symbol' => '€'],
            'NL' => ['currency_code' => 'EUR', 'currency_name' => 'Euro', 'currency_symbol' => '€'],
            'PL' => ['currency_code' => 'PLN', 'currency_name' => 'Polish złoty', 'currency_symbol' => 'zł'],
            'PT' => ['currency_code' => 'EUR', 'currency_name' => 'Euro', 'currency_symbol' => '€'],
            'RO' => ['currency_code' => 'RON', 'currency_name' => 'Romanian leu', 'currency_symbol' => 'lei'],
            'SK' => ['currency_code' => 'EUR', 'currency_name' => 'Euro', 'currency_symbol' => '€'],
            'SI' => ['currency_code' => 'EUR', 'currency_name' => 'Euro', 'currency_symbol' => '€'],
            'ES' => ['currency_code' => 'EUR', 'currency_name' => 'Euro', 'currency_symbol' => '€'],
            'SE' => ['currency_code' => 'SEK', 'currency_name' => 'Swedish krona', 'currency_symbol' => 'kr'],
            'GB' => ['currency_code' => 'GBP', 'currency_name' => 'British pound', 'currency_symbol' => '£'],
            'CH' => ['currency_code' => 'CHF', 'currency_name' => 'Swiss franc', 'currency_symbol' => 'CHF'],
            'NO' => ['currency_code' => 'NOK', 'currency_name' => 'Norwegian krone', 'currency_symbol' => 'kr'],
            'IS' => ['currency_code' => 'ISK', 'currency_name' => 'Icelandic króna', 'currency_symbol' => 'kr'],
            'TR' => ['currency_code' => 'TRY', 'currency_name' => 'Turkish lira', 'currency_symbol' => '₺'],
        ];
    }

    private function boolLabel($value): string
    {
        return $value ? 'Yes' : 'No';
    }

    private function printSummaryTable(): void
    {
        $countries = Country::orderBy('name')->get();

        $rows = $countries->map(fn ($c) => [
            $c->name,
            $c->iso_code,
            $c->currency_code ?: '-',
            $c->currency_symbol ?: '-',
            $c->is_eu_member ? '✓' : '✗',
            $c->vies_available ? '✓' : '✗',
        ])->toArray();

        $this->table(
            ['Country', 'ISO', 'Currency', 'Symbol', 'EU', 'VIES'],
            $rows
        );
    }
}
