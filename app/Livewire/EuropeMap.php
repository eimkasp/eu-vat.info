<?php

namespace App\Livewire;

use App\Models\Country;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;

class EuropeMap extends Component
{
    public $countries;
    public $countryData; // Add this property
    public $maxRate = 0;
    public $minRate = 100;

    public function mount()
    {
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

        // Initialize countryData with uppercase keys
        $this->countryData = $this->countries->mapWithKeys(function ($country) {
            return [
                strtoupper($country->iso_code) => [
                    'iso_code' => $country->iso_code,
                    'name' => $country->name,
                    'rate' => $country->standard_rate,
                    'reduced_rate' => $country->reduced_rate,
                    'slug' => $country->slug,
                ],
            ];
        });
    }

    public function render()
    {
        return view('livewire.europe-map');
    }
}
