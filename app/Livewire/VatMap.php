<?php

namespace App\Livewire;

use App\Models\Country;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;

class VatMap extends Component
{
    public $countries;

    public function mount()
    {
        $this->countries = Cache::remember('map_page_countries', 600, function () {
            return Country::orderBy('name')->get();
        });
    }

    public function render()
    {
        return view('livewire.vat-map');
    }
}
