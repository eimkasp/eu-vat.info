<?php

namespace App\Livewire;

use App\Models\Country;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;

class VatCalculatorForm extends VatCalculator
{
  
    public function mount($country = null, $slug = null) {
        $this->country = $country;
        if ($slug) {
            $this->selectedCountry1 = $slug;
        }

        $this->selectedCountryObject = Country::where('slug', $this->selectedCountry1)->first();

        $this->countries = Cache::remember('all_countries', 600, function () {
            return Country::orderBy('name', 'ASC')->get();
        });
    }
    public function render()
    {
        return view('livewire.vat-calculator-form');
    }
}
