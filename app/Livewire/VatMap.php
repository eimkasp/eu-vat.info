<?php

namespace App\Livewire;

use App\Models\Country;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class VatMap extends Component
{
    public $countries;

    public bool $loadError = false;

    public function mount()
    {
        try {
            $this->countries = Cache::remember('map_page_countries', 600, function () {
                return Country::orderBy('name')->get();
            });

            if ($this->countries === null || $this->countries->isEmpty()) {
                $this->loadError = true;
                $this->countries = collect();
            }
        } catch (\Throwable $e) {
            Log::error('VatMap failed to load countries: '.$e->getMessage());
            $this->loadError = true;
            $this->countries = collect();
        }
    }

    public function render()
    {
        return view('livewire.vat-map');
    }
}
