<?php

namespace App\Livewire;

use App\Models\Country;
use App\Models\VatRate;
use Livewire\Component;

class AllCountriesVatHistory extends Component
{
    public $chartData = [];

    public function mount()
    {
        $countries = Country::orderBy('name')->get();
        $years = range(2000, date('Y'));

        // Fetch all standard rates
        $rates = VatRate::whereIn('type', ['standard', 'standard_rate'])
            ->orderBy('effective_from')
            ->get()
            ->groupBy('country_id');

        $series = [];

        foreach ($countries as $country) {
            $data = [];
            $countryRates = $rates->get($country->id);

            foreach ($years as $year) {
                // Find rate effective at start of year or during year?
                // Usually "rate at year" means rate at Jan 1st or average.
                // Let's pick rate at Jan 1st of that year.
                $date = "$year-01-01";

                $rate = null;
                if ($countryRates) {
                    $r = $countryRates->filter(function ($item) use ($date) {
                        return $item->effective_from <= $date &&
                               ($item->effective_to >= $date || is_null($item->effective_to));
                    })->sortByDesc('effective_from')->first();

                    if ($r) {
                        $rate = $r->rate;
                    } else {
                        // If no rate found (maybe joined EU later?), try finding if there's a rate starting later in that year?
                        // Or use Country standard rate as fallback if no history?
                        // For history chart, better to show null/empty if no data.
                        // But our seeder usually has recent rates.
                        // Let's fallback to the earliest available rate if date is before earliest? No, that's misleading.
                        // Let's fallback to Country model standard rate if we assume it's constant? No.
                        // If null, maybe use 0 or skip.

                        // Fallback: check if there is ANY rate for this country.
                        // If yes, maybe the history doesn't go back to 2000.
                        // Let's try to get the *first* rate if year is before first rate? No.

                        // Let's try to find a rate that started in that year if none was active at start.
                        $rStart = $countryRates->filter(function ($item) use ($year) {
                            return substr($item->effective_from->format('Y-m-d'), 0, 4) == $year;
                        })->first();

                        if ($rStart) {
                            $rate = $rStart->rate;
                        }
                    }
                }

                // If still null, use country standard rate as a specialized fallback for "current" times if close to now?
                // Or just use 0.
                if ($rate === null && $countryRates && $countryRates->count() > 0) {
                    // Check if year is after the last known rate
                    $last = $countryRates->sortByDesc('effective_from')->first();
                    if ($last && $last->effective_from < $date) {
                        $rate = $last->rate;
                    }
                }

                // If absolutely no rate (e.g. missing history), use current standard rate
                if ($rate === null) {
                    $rate = $country->standard_rate;
                }

                $data[] = [
                    'x' => (string) $year,
                    'y' => $rate,
                ];
            }

            $series[] = [
                'name' => $country->name,
                'data' => $data,
            ];
        }

        $this->chartData = $series;
    }

    public function render()
    {
        return view('livewire.all-countries-vat-history');
    }
}
