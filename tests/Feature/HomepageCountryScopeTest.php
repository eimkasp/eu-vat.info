<?php

use App\Livewire\HeroCalculator;
use App\Livewire\Home;
use App\Models\Country;
use Illuminate\Support\Facades\Cache;
use Livewire\Livewire;

it('lists EU member states only on the homepage', function () {
    Cache::clear();

    Country::factory()->create([
        'name' => 'Lithuania',
        'slug' => 'lithuania',
        'iso_code' => 'LT',
        'standard_rate' => 21,
        'is_eu_member' => true,
    ]);

    Country::factory()->create([
        'name' => 'Switzerland',
        'slug' => 'switzerland',
        'iso_code' => 'CH',
        'standard_rate' => 8.1,
        'is_eu_member' => false,
    ]);

    Livewire::test(Home::class)
        ->assertSet('euCountries', function ($countries) {
            return collect($countries)->pluck('name')->all() === ['Lithuania'];
        });
});

it('offers EU member states only in the homepage calculator', function () {
    Cache::clear();

    Country::factory()->create([
        'name' => 'Germany',
        'slug' => 'germany',
        'iso_code' => 'DE',
        'standard_rate' => 19,
        'is_eu_member' => true,
    ]);

    Country::factory()->create([
        'name' => 'Switzerland',
        'slug' => 'switzerland',
        'iso_code' => 'CH',
        'standard_rate' => 8.1,
        'is_eu_member' => false,
    ]);

    Livewire::test(HeroCalculator::class)
        ->assertSet('countries', function ($countries) {
            return collect($countries)->pluck('name')->all() === ['Germany'];
        });
});
