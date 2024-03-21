<?php

namespace App\Livewire;

use Livewire\Component;

class VatCalculator extends Component
{
    public $amount = 0;
    public $country = null;
    public $vat = 0;
    public $total = 0;

    public $countries;
    public function mount($country = null)
    {
        $this->country = $country;
        $this->countries = \App\Models\Country::orderBy('name', 'ASC')->get();
    }
    public function render()
    {
        return view('livewire.vat-calculator');
    }
}
