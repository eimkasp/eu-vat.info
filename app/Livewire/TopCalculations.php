<?php

namespace App\Livewire;

use App\Models\Country;
use Illuminate\Support\Facades\Cache;
use Livewire\Attributes\Computed;
use Livewire\Component;

class TopCalculations extends Component
{
    public const AMOUNTS = [100, 200, 500, 1000, 2500, 5000, 10000];

    /**
     * @return list<array{name: string, slug: string, iso_code: string, standard_rate: float}>
     */
    #[Computed]
    public function countries(): array
    {
        return self::euCountries();
    }

    /**
     * @return list<array{name: string, slug: string, iso_code: string, standard_rate: float}>
     */
    public static function euCountries(): array
    {
        return Cache::remember('top_calculations_countries_v2', 3600, fn () => Country::query()
            ->where('is_eu_member', true)
            ->orderBy('name')
            ->get(['name', 'slug', 'iso_code', 'standard_rate'])
            ->map(fn (Country $country) => [
                'name' => $country->name,
                'slug' => $country->slug,
                'iso_code' => $country->iso_code,
                'standard_rate' => (float) $country->standard_rate,
            ])
            ->all());
    }

    public function render()
    {
        return view('livewire.top-calculations', ['amounts' => self::AMOUNTS]);
    }
}
