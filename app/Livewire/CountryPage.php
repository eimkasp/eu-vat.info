<?php

namespace App\Livewire;

use App\Models\Country;
use Livewire\Component;
use App\Traits\TracksCountryViews;

class CountryPage extends Component
{
    use TracksCountryViews;
    
    public Country $country;

    public function mount($slug, $tab = null)
    {
        $this->country = Country::where('slug', $slug)->firstOrFail();
        
        // If accessed via old tab URL, redirect to main country page
        if ($tab) {
            return $this->redirect(route('country.show', $this->country->slug), navigate: true);
        }
        
        $this->trackCountryView($this->country, 'country-view');
    }

    public function render()
    {
        return view('livewire.country');
    }
}
