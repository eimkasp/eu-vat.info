<?php

namespace Database\Seeders;

use App\Models\Country;
use App\Models\VatRate;
use Illuminate\Database\Seeder;
use League\Csv\Reader;

class VatRateSeeder extends Seeder
{
    /**
     * Territory aliases used by the kdeldycke/vat-rates dataset.
     */
    private const ALIASES = ['EL' => 'GR', 'UK' => 'GB'];

    /**
     * Imports data/vat_rates.csv. Safe to re-run: rows are keyed by country, type and start date.
     */
    public function run(): void
    {
        $path = base_path('data/vat_rates.csv');

        if (! is_file($path)) {
            $this->command?->error('File data/vat_rates.csv not found.');

            return;
        }

        $countries = Country::query()->pluck('id', 'iso_code')->mapWithKeys(fn ($id, $iso) => [strtoupper((string) $iso) => $id]);

        $reader = Reader::createFromPath($path);
        $reader->setHeaderOffset(0);

        foreach ($reader->getRecords() as $record) {
            $countryId = $this->countryIdFor((string) ($record['territory_codes'] ?? ''), $countries->all());

            if ($countryId === null || blank($record['start_date'] ?? null)) {
                continue;
            }

            $type = strtolower(trim((string) $record['rate_type']));
            $values = [
                'rate' => round((float) $record['rate'] * 100, 2),
                'effective_to' => $record['stop_date'] ?: null,
                'source' => 'kdeldycke/vat-rates',
            ];

            $existing = VatRate::query()
                ->where('country_id', $countryId)
                ->where('type', $type)
                ->whereDate('effective_from', $record['start_date'])
                ->first();

            $existing
                ? $existing->update($values)
                : VatRate::create(['country_id' => $countryId, 'type' => $type, 'effective_from' => $record['start_date']] + $values);
        }
    }

    /**
     * Resolves the member-state row of a territory list such as "FR\nMC" or "GR\nEL",
     * ignoring sub-national territories like "AT-6691".
     *
     * @param  array<string, int>  $countries
     */
    private function countryIdFor(string $territories, array $countries): ?int
    {
        foreach (preg_split('/\s*[\r\n]+\s*/', trim($territories)) ?: [] as $code) {
            $code = strtoupper(trim($code));
            $code = self::ALIASES[$code] ?? $code;

            if (preg_match('/^[A-Z]{2}$/', $code) && isset($countries[$code])) {
                return $countries[$code];
            }
        }

        return null;
    }
}
