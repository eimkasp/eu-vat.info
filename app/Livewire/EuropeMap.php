<?php

namespace App\Livewire;

use App\Models\Country;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;

class EuropeMap extends Component
{
    public $countries;
    public $countryData;
    public $maxRate = 0;
    public $minRate = 100;
    public $activeCountry = null;
    public $layout = 'single'; // Add layout property: 'single' or 'split'

    public function mount($activeCountry = null, $layout = 'single')
    {
        $this->activeCountry = $activeCountry;
        $this->layout = $layout;
        $this->countries = Cache::remember('map_countries', 600, function () {
            $countries = Country::all();
            foreach($countries as $country) {
                if($country->standard_rate > $this->maxRate) {
                    $this->maxRate = $country->standard_rate;
                }
                if($country->standard_rate < $this->minRate) {
                    $this->minRate = $country->standard_rate;
                }
            }
            return $countries;
        });

        // Initialize countryData with uppercase keys using iso_code_2
        $this->countryData = $this->countries->mapWithKeys(function ($country) {
            return [
                strtoupper($country->iso_code_2) => [
                    'iso_code' => $country->iso_code_2,
                    'name' => $country->name,
                    'rate' => $country->standard_rate,
                    'reduced_rate' => $country->reduced_rate,
                    'slug' => $country->slug,
                    'active' => $this->activeCountry && $this->activeCountry->id === $country->id,
                ],
            ];
        });
    }

    public function render()
    {
        return view('livewire.europe-map');
    }
}
