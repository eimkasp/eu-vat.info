<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class RelatedCountries extends Component
{
    public $relatedCountries = [];

    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        //
        $this->relatedCountries = \App\Models\Country::orderBy('standard_rate', 'ASC')->take(10)->get();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.related-countries');
    }
}
