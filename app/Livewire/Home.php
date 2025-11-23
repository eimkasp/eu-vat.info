<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Country;
use Illuminate\Support\Facades\Cache;

class Home extends Component
{
    public $euCountries = [];
    public $search = '';
    public $selectedCountryIso = null;
    public $selectedCountry = null;

    public function mount()
    {
        // Set default country (Lithuania)
        $this->selectedCountry = Country::where('slug', 'lithuania-lt')->first();
    }

    public function selectCountry($slug)
    {
        $this->selectedCountry = Country::where('slug', $slug)->first();
    }

    public function render()
    {
        $this->euCountries = Country::where('name', 'like', '%'.$this->search.'%')->orderBy('standard_rate', 'ASC')->get();
        return view('livewire.home');
    }
}
