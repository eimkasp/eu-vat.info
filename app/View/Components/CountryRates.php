<?php

namespace App\View\Components;

use App\Models\Country;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class CountryRates extends Component
{
    public $country;

    /**
     * Create a new component instance.
     */
    public function __construct($country = null)
    {
        $this->country = $country;
        if ($this->country == null) {
            $this->country = Country::first();
        }
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.country-rates');
    }
}
