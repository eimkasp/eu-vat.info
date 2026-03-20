<?php

namespace App\Livewire;

use App\Models\VatRate;
use Livewire\Component;

class VatRateChanges extends Component
{
    public $recentChanges = [];

    public $futureChanges = [];

    public function mount()
    {
        // Future changes
        $futureRates = VatRate::with('country')
            ->where('effective_from', '>', now())
            ->orderBy('effective_from', 'asc')
            ->limit(5)
            ->get();

        // Batch-load previous rates for all future changes
        $this->futureChanges = $this->attachDiffs($futureRates);

        // Recent changes (past)
        $recentRates = VatRate::with('country')
            ->where('effective_from', '<=', now())
            ->where('effective_from', '>=', now()->subYears(2))
            ->orderBy('effective_from', 'desc')
            ->limit(10)
            ->get()
            ->groupBy('country_id')
            ->map(function ($rates) {
                return $rates->first();
            })
            ->take(5)
            ->values();

        // Batch-load previous rates for all recent changes
        $this->recentChanges = $this->attachDiffs($recentRates);
    }

    /**
     * Batch-load previous rates to avoid N+1 queries.
     */
    private function attachDiffs($rates)
    {
        if ($rates->isEmpty()) {
            return $rates;
        }

        // Collect all (country_id, type, effective_from) tuples
        $previousRates = collect();
        foreach ($rates as $rate) {
            $prev = VatRate::where('country_id', $rate->country_id)
                ->where('type', $rate->type)
                ->where('effective_from', '<', $rate->effective_from)
                ->orderBy('effective_from', 'desc')
                ->first();
            $previousRates->put($rate->id, $prev);
        }

        return $rates->map(function ($rate) use ($previousRates) {
            $previous = $previousRates->get($rate->id);
            $rate->diff = $previous ? $rate->rate - $previous->rate : 0;

            return $rate;
        });
    }

    public function render()
    {
        return view('livewire.vat-rate-changes');
    }
}
