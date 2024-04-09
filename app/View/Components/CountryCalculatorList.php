<?php

namespace App\View\Components;

use App\Models\Country;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\Component;

class CountryCalculatorList extends Component
{
    public $countries;
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        //
        $this->countries = Cache::remember('all_countries', 600, function () {
            return Country::orderBy('name', 'ASC')->get();
        });
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.country-calculator-list');
    }
}
