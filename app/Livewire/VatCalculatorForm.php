<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Cache;
use Livewire\Component;

class VatCalculatorForm extends VatCalculator
{
  
    public function render()
    {
        return view('livewire.vat-calculator-form');
    }
}
