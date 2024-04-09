<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class SavedSearches extends Component
{
    public $saved_searches = [];
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        //
        $this->saved_searches = session()->get('saved_searched');

        if(is_array($this->saved_searches)) {
            $this->saved_searches = array_reverse($this->saved_searches);
            $this->saved_searches = array_slice($this->saved_searches, 0, 8);
        } else {
            $this->saved_searches = [];
        }
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.saved-searches');
    }
}
