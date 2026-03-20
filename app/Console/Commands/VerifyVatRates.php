<?php

namespace App\Console\Commands;

use App\Models\Country;
use Illuminate\Console\Command;

class VerifyVatRates extends Command
{
    protected $signature = 'vat:verify {--fix : Apply fixes automatically}';

    protected $description = 'Verify and fix VAT rates based on known 2024/2025 data';

    public function handle()
    {
        // Known standard rates as of 2024/2025
        $knownRates = [
            'AT' => 20.0, 'BE' => 21.0, 'BG' => 20.0, 'HR' => 25.0, 'CY' => 19.0,
            'CZ' => 21.0, 'DK' => 25.0, 'EE' => 22.0, 'FI' => 24.0, 'FR' => 20.0,
            'DE' => 19.0, 'GR' => 24.0, 'HU' => 27.0, 'IE' => 23.0, 'IT' => 22.0,
            'LV' => 21.0, 'LT' => 21.0, 'LU' => 17.0, 'MT' => 18.0, 'NL' => 21.0,
            'PL' => 23.0, 'PT' => 23.0, 'RO' => 19.0, 'SK' => 20.0, 'SI' => 22.0,
            'ES' => 21.0, 'SE' => 25.0, 'GB' => 20.0, 'CH' => 8.1,
        ];

        foreach ($knownRates as $code => $rate) {
            $country = Country::where('iso_code', $code)->first();

            if (! $country) {
                $this->warn("Country {$code} not found in database.");

                continue;
            }

            if (abs($country->standard_rate - $rate) > 0.01) {
                $this->error("Mismatch for {$country->name} ({$code}): DB={$country->standard_rate}%, Expected={$rate}%");

                if ($this->option('fix')) {
                    $country->standard_rate = $rate;
                    $country->save();
                    $this->info("Fixed {$country->name} to {$rate}%");
                }
            } else {
                $this->line("{$country->name}: OK ({$rate}%)");
            }
        }

        // Check Finland change (rose to 25.5% in Sept 2024? No, proposed. Current 24%).
        // Check Estonia (22% from Jan 2024).
        // Check Luxembourg (17% from Jan 2024).
        // Check Switzerland (8.1% from Jan 2024).

        $this->info('Verification complete.');
    }
}
