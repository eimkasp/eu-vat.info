<?php

namespace App\Livewire;

use App\Models\Country;
use App\Traits\TracksCountryViews;
use Livewire\Component;

class CountryPage extends Component
{
    use TracksCountryViews;

    public Country $country;

    public function mount($slug, $tab = null)
    {
        $this->country = Country::where('slug', $slug)->firstOrFail();

        // Always redirect to the combined vat-calculator page
        return redirect(route('vat-calculator.country', $this->country->slug), 301);

        $this->trackCountryView($this->country, 'country-view');
    }

    public function render()
    {
        return view('livewire.country');
    }
}
