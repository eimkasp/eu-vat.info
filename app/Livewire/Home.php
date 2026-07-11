<?php

namespace App\Livewire;

use App\Models\Country;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;

class Home extends Component
{
    public $euCountries = [];

    public $search = '';

    public $selectedCountryIso = null;

    public $selectedCountry = null;

    public function mount()
    {
        // Set default country (Lithuania or fallback to first)
        $this->selectedCountry = Country::where('name', 'Lithuania')->first()
            ?? Country::where('name', 'United Kingdom')->first()
            ?? Country::first();
    }

    public function selectCountry($slug)
    {
        $this->selectedCountry = Country::where('slug', $slug)->first();
    }

    public function render()
    {
        $countries = Cache::remember('all_eu_member_countries_v2', 3600, function () {
            return Country::where('is_eu_member', true)
                ->orderBy('standard_rate', 'ASC')
                ->get();
        });

        if ($this->search) {
            $search = strtolower($this->search);
            $countries = $countries->filter(function ($country) use ($search) {
                return str_contains(strtolower($country->name), $search);
            });
        }

        $this->euCountries = $countries->values();

        return view('livewire.home');
    }
}
