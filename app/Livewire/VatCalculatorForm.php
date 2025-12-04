<?php

namespace App\Livewire;

class VatCalculatorForm extends VatCalculator
{
    public function mount($country = null, $slug = null)
    {
        parent::mount($country, $slug);
    }

    public function render()
    {
        return view('livewire.vat-calculator-form');
    }
}
