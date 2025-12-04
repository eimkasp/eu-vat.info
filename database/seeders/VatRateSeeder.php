<?php

namespace Database\Seeders;

use App\Models\Country;
use App\Models\VatRate;
use Illuminate\Database\Seeder;
use League\Csv\Reader;

class VatRateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Check if file exists
        if (! file_exists(base_path('data/vat_rates.csv'))) {
            $this->command->error('File data/vat_rates.csv not found.');

            return;
        }

        $csv = Reader::createFromPath(base_path('data/vat_rates.csv'), 'r');
        $csv->setHeaderOffset(0);

        foreach ($csv as $record) {
            // CSV columns: start_date, stop_date, territory_codes, currency_code, rate, rate_type, description
            // territory_codes can be "AT" or multiple? Assuming single for now based on head.
            $countryCode = $record['territory_codes'];

            // Skip if no country code
            if (empty($countryCode)) {
                continue;
            }

            // Match "Austria (AT)" with "AT"
            $country = Country::where('iso_code', 'LIKE', "%($countryCode)%")->first();

            if (! $country) {
                // Fallback: try exact match or just name match if needed
                $country = Country::where('iso_code', $countryCode)->first();
            }

            if (! $country) {
                continue;
            }

            // Rate in CSV is 0.2 for 20%, DB expects 20.00
            $rate = floatval($record['rate']) * 100;

            VatRate::updateOrCreate(
                [
                    'country_id' => $country->id,
                    'type' => $this->mapRateType($record['rate_type']),
                    'effective_from' => $record['start_date'],
                    'rate' => $rate,
                ],
                [
                    'effective_to' => $record['stop_date'] ?: null,
                    'source' => 'kdeldycke/vat-rates',
                ]
            );
        }
    }

    private function mapRateType($type)
    {
        // Map CSV types to our DB types
        // CSV types might be: standard, reduced, parking, super_reduced
        // We can normalize them here
        return strtolower($type);
    }
}
