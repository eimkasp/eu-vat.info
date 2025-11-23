<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\VatRate;
use Illuminate\Support\Facades\DB;

class VatRateChanges extends Component
{
    public $recentChanges = [];

    public function mount()
    {
        // Get recent rate changes (where effective_from is within the last 2 years)
        $this->recentChanges = VatRate::with('country')
            ->where('effective_from', '>=', now()->subYears(2))
            ->orderBy('effective_from', 'desc')
            ->limit(10)
            ->get()
            ->groupBy('country_id')
            ->map(function ($rates) {
                return $rates->first(); // Get the most recent change per country
            })
            ->take(5)
            ->values();
    }

    public function render()
    {
        return view('livewire.vat-rate-changes');
    }
}
