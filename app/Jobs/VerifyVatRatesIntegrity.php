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

        foreach ($countries as $country) {
            // Check Standard Rate
            $latestStandard = VatRate::where('country_id', $country->id)
                ->where('type', 'standard')
                ->where('effective_from', '<=', now())
                ->where(function ($query) {
                    $query->whereNull('effective_to')
                          ->orWhere('effective_to', '>=', now());
                })
                ->orderBy('effective_from', 'desc')
                ->first();

            if ($latestStandard) {
                if (abs($country->standard_rate - $latestStandard->rate) > 0.01) {
                    Log::warning("Mismatch for {$country->name}: Country rate {$country->standard_rate} vs VatRate {$latestStandard->rate}");
                    
                    // Auto-fix
                    $country->standard_rate = $latestStandard->rate;
                    $country->save();
                    $fixed++;
                    $issues++;
                }
            } else {
                // If no VatRate exists, maybe create one from Country rate?
                // Or just log warning.
                Log::warning("No active standard VatRate found for {$country->name}");
            }
            
            // We could do similar checks for reduced rates if we had a structured way to map them.
            // Country model has 'reduced_rate' string/text, but VatRate has 'reduced' type.
        }

        Log::info("VerifyVatRatesIntegrity job finished. Found {$issues} issues, fixed {$fixed}.");
    }
}
