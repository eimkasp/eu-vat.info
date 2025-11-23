<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\VatRate;
use Illuminate\Support\Facades\DB;

class VatRateChanges extends Component
{
    public $recentChanges = [];
    public $futureChanges = [];

    public function mount()
    {
        // Future changes
        $this->futureChanges = VatRate::with('country')
            ->where('effective_from', '>', now())
            ->orderBy('effective_from', 'asc')
            ->limit(5)
            ->get()
            ->map(function ($rate) {
                return $this->appendDiff($rate);
            });

        // Recent changes (past)
        $this->recentChanges = VatRate::with('country')
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
            ->values()
            ->map(function ($rate) {
                return $this->appendDiff($rate);
            });
    }

    private function appendDiff($rate)
    {
        $previous = VatRate::where('country_id', $rate->country_id)
            ->where('type', $rate->type)
            ->where('effective_from', '<', $rate->effective_from)
            ->orderBy('effective_from', 'desc')
            ->first();

        $rate->diff = $previous ? $rate->rate - $previous->rate : 0;
        return $rate;
    }

    public function render()
    {
        return view('livewire.vat-rate-changes');
    }
}
