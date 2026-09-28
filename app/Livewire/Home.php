<?php

namespace App\Livewire;

use App\Models\Country;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Livewire\Attributes\Url;
use Livewire\Component;

class Home extends Component
{
    #[Url(except: '')]
    public string $search = '';

    public function render()
    {
        /** @var Collection<int, Country> $countries */
        $countries = Cache::remember('home_eu_countries_v3', 3600, fn () => Country::query()
            ->where('is_eu_member', true)
            ->orderBy('standard_rate')
            ->orderBy('name')
            ->get());

        $rates = $countries->map(fn (Country $country) => (float) $country->standard_rate);

        return view('livewire.home', [
            'countries' => $countries,
            'stats' => $countries->isEmpty() ? null : [
                'lowest' => $countries->first(),
                'highest' => $countries->sortByDesc(fn (Country $country) => (float) $country->standard_rate)->first(),
                'average' => round($rates->avg(), 1),
                'count' => $countries->count(),
            ],
        ]);
    }
}
