<?php

namespace App\Livewire;

use App\Models\VatRateChange;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;

class VatRateChanges extends Component
{
    public function render()
    {
        [$upcoming, $recent] = Cache::remember('sidebar_vat_rate_changes_v2', 900, fn () => [
            VatRateChange::query()
                ->with('country:id,name,slug,iso_code')
                ->whereDate('change_date', '>', now())
                ->orderBy('change_date')
                ->limit(3)
                ->get(),
            VatRateChange::query()
                ->with('country:id,name,slug,iso_code')
                ->whereDate('change_date', '<=', now())
                ->whereDate('change_date', '>=', now()->subYears(3))
                ->orderByDesc('change_date')
                ->limit(5)
                ->get(),
        ]);

        return view('livewire.vat-rate-changes', [
            'upcoming' => $upcoming,
            'recent' => $recent,
        ]);
    }
}
