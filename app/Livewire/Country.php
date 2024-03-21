<?php

namespace App\Livewire;

use Livewire\Component;

class Country extends Component
{
    
    public $slug;
    public $country;
 
    public function mount($slug) 
    {
        $this->country = \App\Models\Country::where('slug', $slug)->first();
    }

    public function render()
    {
        return view('livewire.country');
    }
}
