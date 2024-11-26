<?php

namespace App\Livewire;

use Livewire\Component;

class Home extends Component
{
    public $euCountries = [];
    public $search = '';
    public $selectedCountryIso = null;

    public function mount()
    {
        $this->listenForCountrySelection();
    }

    public function listenForCountrySelection()
    {
       
    }

    public function countrySelected($isoCode)
    {
        $this->selectedCountryIso = $isoCode;
    }

    public function render()
    {
        $this->euCountries = \App\Models\Country::where('name', 'like', '%'.$this->search.'%')->orderBy('standard_rate', 'ASC')->get();
        return view('livewire.home');
    }
}
