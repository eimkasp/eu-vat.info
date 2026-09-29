<?php

namespace App\Livewire;

use App\Models\Country;
use Livewire\Component;

class RecentCountries extends Component
{
    public function render()
    {
        $ids = array_values(array_filter(array_map('intval', (array) session('recent_countries', []))));

        $countries = $ids === []
            ? collect()
            : Country::query()
                ->whereIn('id', $ids)
                ->get(['id', 'name', 'slug', 'iso_code', 'standard_rate'])
                ->sortBy(fn (Country $country) => array_search($country->id, $ids, true))
                ->values();

        return view('livewire.recent-countries', ['countries' => $countries]);
    }
}
