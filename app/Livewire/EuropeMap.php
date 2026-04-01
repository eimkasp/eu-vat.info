<?php

namespace App\Livewire;

use App\Models\Country;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class EuropeMap extends Component
{
    public $countries;

    public $countryData;

    public $maxRate = 0;

    public $minRate = 100;

    public $activeCountry = null;

    public $layout = 'single'; // Add layout property: 'single' or 'split'

    public bool $loadError = false;

    public function mount($activeCountry = null, $layout = 'single')
    {
        $this->activeCountry = $activeCountry;
        $this->layout = $layout;

        try {
            $this->countries = Cache::remember('map_countries', 600, function () {
                $countries = Country::all();
                foreach ($countries as $country) {
                    if ($country->standard_rate > $this->maxRate) {
                        $this->maxRate = $country->standard_rate;
                    }
                    if ($country->standard_rate < $this->minRate) {
                        $this->minRate = $country->standard_rate;
                    }
                }

                return $countries;
            });

            if ($this->countries === null || $this->countries->isEmpty()) {
                $this->loadError = true;
                $this->countries = collect();
                $this->countryData = collect();
                return;
            }

            // Initialize countryData with uppercase keys using iso_code
            $this->countryData = $this->countries->mapWithKeys(function ($country) {
                return [
                    strtoupper($country->iso_code) => [
                        'iso_code' => $country->iso_code,
                        'name' => $country->name,
                        'rate' => $country->standard_rate,
                        'reduced_rate' => $country->reduced_rate,
                        'slug' => $country->slug,
                        'active' => $this->activeCountry && $this->activeCountry->id === $country->id,
                    ],
                ];
            });
        } catch (\Throwable $e) {
            Log::error('EuropeMap failed to load countries: '.$e->getMessage());
            $this->loadError = true;
            $this->countries = collect();
            $this->countryData = collect();
        }
    }

    public function render()
    {
        return view('livewire.europe-map');
    }
}
