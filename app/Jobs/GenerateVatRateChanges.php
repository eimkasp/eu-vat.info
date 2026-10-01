<?php

namespace App\Jobs;

use App\Models\Country;
use App\Models\VatRate;
use App\Models\VatRateChange;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class GenerateVatRateChanges implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public const SAME_EVENT_WINDOW_DAYS = 200;

    public function __construct()
    {
        //
    }

    public function handle()
    {
        Log::info('GenerateVatRateChanges job started.');

        $countries = Country::all();
        $created = 0;

        foreach ($countries as $country) {
            $types = ['standard', 'reduced', 'super_reduced', 'parking'];

            foreach ($types as $type) {
                $rates = VatRate::where('country_id', $country->id)
                    ->where('type', $type)
                    ->orderBy('effective_from', 'asc')
                    ->get();

                if ($rates->count() < 2) {
                    continue;
                }

                for ($i = 1; $i < $rates->count(); $i++) {
                    $prev = $rates[$i - 1];
                    $curr = $rates[$i];

                    if ($prev->rate != $curr->rate) {
                        $exists = VatRateChange::where('country_id', $country->id)
                            ->where(fn ($query) => $query
                                ->where('vat_rate_id', $curr->id)
                                ->orWhere(fn ($query) => $query
                                    ->where('rate_type', $type)
                                    ->where('old_rate', $prev->rate)
                                    ->where('new_rate', $curr->rate)
                                    ->whereBetween('change_date', [
                                        $curr->effective_from->copy()->subDays(self::SAME_EVENT_WINDOW_DAYS)->toDateString(),
                                        $curr->effective_from->copy()->addDays(self::SAME_EVENT_WINDOW_DAYS)->toDateString(),
                                    ])))
                            ->exists();

                        if (! $exists) {
                            $change = new VatRateChange;
                            $change->country_id = $country->id;
                            $change->vat_rate_id = $curr->id;
                            $change->rate_type = $type;
                            $change->old_rate = $prev->rate;
                            $change->new_rate = $curr->rate;
                            $change->change_date = $curr->effective_from;
                            $change->description = "Rate changed from {$prev->rate}% to {$curr->rate}%";
                            $change->source = $curr->source;
                            $change->percentage_change = $change->calculatePercentageChange();
                            $change->change_direction = $change->determineChangeDirection();
                            $change->save();

                            $created++;
                        }
                    }
                }
            }
        }

        Log::info("GenerateVatRateChanges job finished. Created {$created} changes.");
    }
}
