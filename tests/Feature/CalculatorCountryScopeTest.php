<?php

use App\Models\Country;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('selects EU and configured other European calculator countries', function () {
    config()->set('calculator.additional_country_slugs', ['norway']);

    Country::factory()->create([
        'name' => 'Germany',
        'slug' => 'germany',
        'iso_code' => 'DE',
        'standard_rate' => 19,
        'is_eu_member' => true,
    ]);
    Country::factory()->create([
        'name' => 'Norway',
        'slug' => 'norway',
        'iso_code' => 'NO',
        'standard_rate' => 25,
        'is_eu_member' => false,
    ]);
    Country::factory()->create([
        'name' => 'Canada',
        'slug' => 'canada',
        'iso_code' => 'CA',
        'standard_rate' => 5,
        'is_eu_member' => false,
    ]);
    Country::factory()->create([
        'name' => 'No Rate',
        'slug' => 'no-rate',
        'iso_code' => 'NR',
        'standard_rate' => 0,
        'is_eu_member' => true,
    ]);

    expect(Country::calculatorAvailable()->orderBy('name')->pluck('slug')->all())
        ->toBe(['germany', 'norway']);
});

it('reports calculator group and instance availability', function () {
    config()->set('calculator.additional_country_slugs', ['switzerland']);

    $eu = Country::factory()->create([
        'name' => 'Malta',
        'slug' => 'malta',
        'iso_code' => 'MT',
        'standard_rate' => 18,
        'is_eu_member' => true,
    ]);
    $other = Country::factory()->create([
        'name' => 'Switzerland',
        'slug' => 'switzerland',
        'iso_code' => 'CH',
        'standard_rate' => 8.1,
        'is_eu_member' => false,
    ]);

    expect($eu->isCalculatorAvailable())->toBeTrue()
        ->and($eu->calculatorGroup())->toBe('eu')
        ->and($other->isCalculatorAvailable())->toBeTrue()
        ->and($other->calculatorGroup())->toBe('other_europe');
});
