<?php

namespace App\Livewire;

use App\Models\Country;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;

class TopCalculationsAmount extends Component
{
    public int $amount;

    public array $countries = [];

    public array $allAmounts = [100, 200, 500, 1000, 2500, 5000, 10000];

    public function mount(int $amount)
    {
        if (! in_array($amount, $this->allAmounts)) {
            abort(404);
        }

        $this->amount = $amount;

        $this->countries = Cache::remember('top_calculations_countries', 3600, function () {
            return Country::orderBy('name')
                ->get(['id', 'name', 'slug', 'iso_code', 'standard_rate', 'reduced_rate', 'currency_symbol', 'currency_code'])
                ->toArray();
        });
    }

    public function render()
    {
        return view('livewire.top-calculations-amount');
    }
}
