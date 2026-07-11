<?php

namespace App\Livewire;

use App\Models\VatRateChange;
use Livewire\Component;

class VatChangeEvent extends Component
{
    public VatRateChange $change;

    public function mount(string $slug, string $rateType, string $date): void
    {
        $this->change = VatRateChange::query()
            ->with('country')
            ->whereHas('country', fn ($query) => $query
                ->where('slug', $slug)
                ->where('is_eu_member', true))
            ->where('rate_type', $rateType)
            ->whereDate('change_date', $date)
            ->firstOrFail();
    }

    public function render()
    {
        return view('livewire.vat-change-event');
    }
}
