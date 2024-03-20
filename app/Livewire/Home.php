<?php

namespace App\Livewire;

use Livewire\Component;

class Home extends Component
{
    public $euCountries = [];

    public function mount()
    {
        $this->euCountries = \App\Models\Country::all();
    }
    public function render()
    {
        return view('livewire.home');
    }
}
