<?php

namespace App\Livewire;

use App\Models\Country;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class VatMap extends Component
{
    public function render()
    {
        try {
            $countries = Country::forMap();
        } catch (\Throwable $exception) {
            Log::error('VAT map failed to load countries: '.$exception->getMessage());
            $countries = collect();
        }

        return view('livewire.vat-map', [
            'countries' => $countries,
            'ranked' => $countries->sortByDesc(fn (Country $country) => (float) $country->standard_rate)->values(),
        ]);
    }
}
