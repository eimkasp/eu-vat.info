<?php

namespace App\Livewire;

use App\Models\Country;
use Livewire\Component;

class CountryVatHistory extends Component
{
    public Country $country;

    public function mount(string $slug): void
    {
        $this->country = Country::query()
            ->where('slug', $slug)
            ->where('is_eu_member', true)
            ->firstOrFail();

        abort_unless($this->country->hasVatHistory(), 404);
    }

    public function render()
    {
        return view('livewire.country-vat-history', [
            'rates' => $this->country->vatRates()->orderByDesc('effective_from')->get(),
            'changes' => $this->country->vatRateChanges()->orderByDesc('change_date')->get(),
        ]);
    }
}
