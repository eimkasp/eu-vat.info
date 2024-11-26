<?php

namespace App\Livewire;

use App\Models\Country;
use Livewire\Component;
use App\Traits\TracksCountryViews;

class CountryPage extends Component
{
    use TracksCountryViews;
    
    public Country $country;

    public function mount($slug)
    {
        $this->country = Country::where('slug', $slug)->firstOrFail();
        $this->trackCountryView($this->country, 'country-view');
    }

    public function render()
    {
        return view('livewire.country');
    }
}
