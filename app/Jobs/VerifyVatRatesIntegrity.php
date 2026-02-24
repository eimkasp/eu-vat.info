<?php

namespace App\Jobs;

use App\Models\Country;
use App\Models\VatRate;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class VerifyVatRatesIntegrity implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct()
    {
        //
    }

    public function handle()
    {
        Log::info('VerifyVatRatesIntegrity job started.');
        
        $countries = Country::all();
        $issues = 0;
        $fixed = 0;

        $rateTypeMapping = [
            'standard' => 'standard_rate',
            'reduced' => 'reduced_rate',
            'super_reduced' => 'super_reduced_rate',
            'parking' => 'parking_rate',
        ];

        foreach ($countries as $country) {
            foreach ($rateTypeMapping as $vatType => $countryField) {
                $latestRate = VatRate::where('country_id', $country->id)
                    ->where('type', $vatType)
                    ->where('effective_from', '<=', now())
                    ->where(function ($query) {
                        $query->whereNull('effective_to')
                              ->orWhere('effective_to', '>=', now());
                    })
                    ->orderBy('effective_from', 'desc')
                    ->first();

                if ($latestRate) {
                    $countryRate = $country->{$countryField};
                    if ($countryRate !== null && abs($countryRate - $latestRate->rate) > 0.01) {
                        Log::warning("Mismatch for {$country->name} ({$vatType}): Country rate {$countryRate} vs VatRate {$latestRate->rate}");
                        
                        $country->{$countryField} = $latestRate->rate;
                        $country->save();
                        $fixed++;
                        $issues++;
                    }
                }
            }
        }

        Log::info("VerifyVatRatesIntegrity job finished. Found {$issues} issues, fixed {$fixed}.");
    }
}
