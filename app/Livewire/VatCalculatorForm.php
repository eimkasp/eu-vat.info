<?php

namespace App\Livewire;

use App\Models\Country;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;

class VatCalculatorForm extends VatCalculator
{
    public function mount($country = null, $slug = null) {
        parent::mount($country, $slug);
    }

    public function render()
    {
        return view('livewire.vat-calculator-form');
    }
}
