<?php

namespace App\Console\Commands;

use App\Jobs\GenerateVatRateChanges;
use App\Jobs\UpdateVatRates;
use App\Jobs\VerifyVatRatesIntegrity;
use App\Models\Country;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class SyncAllData extends Command
{
    protected $signature = 'data:sync
        {--skip-rates : Skip VAT rate refresh from GitHub}
        {--skip-country-data : Skip country metadata validation (currency, EU membership)}
        {--skip-changes : Skip generating VAT rate change records}
        {--dry-run : Show what would change without applying fixes}';

    protected $description = 'Full data sync: refresh VAT rates, validate country metadata (currency, EU membership, VIES), and generate change records';

    /**
     * Authoritative list of EU member state ISO 3166-1 alpha-2 codes.
     */
    private const EU_MEMBERS = [
        'AT', 'BE', 'BG', 'HR', 'CY', 'CZ', 'DK', 'EE', 'FI', 'FR',
        'DE', 'GR', 'HU', 'IE', 'IT', 'LV', 'LT', 'LU', 'MT', 'NL',
        'PL', 'PT', 'RO', 'SK', 'SI', 'ES', 'SE',
    ];

    public function handle(): int
    {
        $startTime = microtime(true);
        $dryRun = $this->option('dry-run');

        $this->info('🔄 Starting full data sync...');
        if ($dryRun) {
            $this->warn('DRY RUN — no changes will be applied.');
        }
        $this->newLine();

        $failed = false;

        // Step 1: VAT rates from GitHub
        if (! $this->option('skip-rates')) {
            $this->info('━━━ Step 1/3: VAT Rates ━━━');
            if ($dryRun) {
                $this->comment('  Would download and sync VAT rates from kdeldycke/vat-rates.');
            } else {
                try {
                    $this->info('  Downloading latest VAT rates from GitHub...');
                    (new UpdateVatRates)->handle();
                    $this->info('  ✓ VAT rates synced.');

                    $this->info('  Verifying data integrity...');
                    (new VerifyVatRatesIntegrity)->handle();
                    $this->info('  ✓ Integrity check passed.');
                } catch (\Exception $e) {
                    $this->error("  ✗ VAT rate sync failed: {$e->getMessage()}");
                    $failed = true;
                }
            }
        } else {
            $this->info('━━━ Step 1/3: VAT Rates — skipped ━━━');
        }
        $this->newLine();

        // Step 2: Country metadata (currency, EU membership, VIES)
        if (! $this->option('skip-country-data')) {
            $this->info('━━━ Step 2/3: Country Metadata ━━━');
            $this->syncCountryMetadata($dryRun);
        } else {
            $this->info('━━━ Step 2/3: Country Metadata — skipped ━━━');
        }
        $this->newLine();

        // Step 3: Generate change records
        if (! $this->option('skip-changes')) {
            $this->info('━━━ Step 3/3: Change Records ━━━');
            if ($dryRun) {
                $this->comment('  Would generate VAT rate change records.');
            } else {
                try {
                    (new GenerateVatRateChanges)->handle();
                    $this->info('  ✓ Change records generated.');
                } catch (\Exception $e) {
                    $this->error("  ✗ Change record generation failed: {$e->getMessage()}");
                    $failed = true;
                }
            }
        } else {
            $this->info('━━━ Step 3/3: Change Records — skipped ━━━');
        }

        $elapsed = round(microtime(true) - $startTime, 2);
        $this->newLine();

        if ($failed) {
            $this->error("⚠ Sync completed with errors in {$elapsed}s");

            return self::FAILURE;
        }

        if ($dryRun) {
            $this->info("✅ Dry run complete in {$elapsed}s — use without --dry-run to apply.");
        } else {
            $this->info("✅ Full data sync complete in {$elapsed}s");
        }

        return self::SUCCESS;
    }

    private function syncCountryMetadata(bool $dryRun): void
    {
        $countries = Country::all();
        $this->info("  Fetching currency data from REST Countries API...");
        $apiData = $this->fetchCurrencyData($countries);

        $issueCount = 0;
        $fixes = [];

        foreach ($countries as $country) {
            $iso = $country->iso_code;
            $countryFixes = [];

            // EU membership
            $shouldBeEu = in_array($iso, self::EU_MEMBERS, true);
            if ((bool) $country->is_eu_member !== $shouldBeEu) {
                $this->line("  <comment>{$country->name}:</comment> EU Member " . ($shouldBeEu ? 'No → Yes' : 'Yes → No'));
                $countryFixes['is_eu_member'] = $shouldBeEu;
                $issueCount++;
            }

            // VIES (same as EU membership)
            if ((bool) $country->vies_available !== $shouldBeEu) {
                $this->line("  <comment>{$country->name}:</comment> VIES " . ($shouldBeEu ? 'No → Yes' : 'Yes → No'));
                $countryFixes['vies_available'] = $shouldBeEu;
                $issueCount++;
            }

            // Currency from API
            if (isset($apiData[$iso])) {
                $api = $apiData[$iso];
                foreach (['currency_code', 'currency' => 'currency_name', 'currency_symbol'] as $dbField => $apiField) {
                    if (is_int($dbField)) {
                        $dbField = $apiField;
                    }
                    if (! empty($api[$apiField]) && $country->{$dbField} !== $api[$apiField]) {
                        $this->line("  <comment>{$country->name}:</comment> {$dbField}: '{$country->{$dbField}}' → '{$api[$apiField]}'");
                        $countryFixes[$dbField] = $api[$apiField];
                        $issueCount++;
                    }
                }
            }

            if (! empty($countryFixes)) {
                $fixes[$country->id] = $countryFixes;
            }
        }

        if ($issueCount === 0) {
            $this->info('  ✓ All country metadata is correct.');

            return;
        }

        $this->warn("  Found {$issueCount} issues across " . count($fixes) . ' countries.');

        if ($dryRun) {
            return;
        }

        foreach ($fixes as $countryId => $data) {
            Country::where('id', $countryId)->update($data);
        }

        $this->info('  ✓ Fixed ' . count($fixes) . ' countries.');
    }

    private function fetchCurrencyData($countries): array
    {
        $codes = $countries->pluck('iso_code')->filter()->implode(',');

        try {
            $response = Http::timeout(15)->get('https://restcountries.com/v3.1/alpha', [
                'codes' => $codes,
                'fields' => 'cca2,currencies',
            ]);

            if ($response->successful()) {
                $data = [];
                foreach ($response->json() as $item) {
                    $cca2 = $item['cca2'] ?? null;
                    if (! $cca2 || empty($item['currencies'])) {
                        continue;
                    }
                    $currencyCode = array_key_first($item['currencies']);
                    $info = $item['currencies'][$currencyCode];
                    $data[$cca2] = [
                        'currency_code' => $currencyCode,
                        'currency_name' => $info['name'] ?? null,
                        'currency_symbol' => $info['symbol'] ?? null,
                    ];
                }

                return $data;
            }
        } catch (\Exception $e) {
            $this->warn("  API unavailable ({$e->getMessage()}), using fallback data.");
        }

        return $this->fallbackCurrencyData();
    }

    private function fallbackCurrencyData(): array
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
}
