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
        ->assertViewHas('countries', fn ($countries) => $countries->pluck('name')->all() === ['Lithuania'])
        ->assertSee('Lithuania');
});

it('groups supported non-EU countries separately in the homepage calculator', function () {
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

    $countries = Livewire::test(HeroCalculator::class)->instance()->countries;

    expect(array_column($countries, 'name'))->toBe(['Germany', 'Switzerland'])
        ->and(array_column($countries, 'group'))->toBe(['eu', 'other_europe']);
});
