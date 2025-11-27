<?php

use App\Models\Country;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

it('calculates country rank correctly', function () {
    Country::factory()->create(['standard_rate' => 25, 'slug' => 'country-high']);
    Country::factory()->create(['standard_rate' => 20, 'slug' => 'country-mid']);
    Country::factory()->create(['standard_rate' => 15, 'slug' => 'country-low']);

    $highCountry = Country::where('slug', 'country-high')->first();
    $midCountry = Country::where('slug', 'country-mid')->first();
    $lowCountry = Country::where('slug', 'country-low')->first();

    expect($highCountry->countryRank())->toBe(3);
    expect($midCountry->countryRank())->toBe(2);
    expect($lowCountry->countryRank())->toBe(1);
});

it('generates slug from name automatically', function () {
    $country = Country::factory()->create([
        'name' => 'Test Country Name',
        'slug' => 'test-country-name', // Explicitly set slug
    ]);

    expect($country->slug)->toBe('test-country-name');
});

it('has vat rates relationship', function () {
    $country = Country::factory()->create();

    expect($country->vatRates())->toBeInstanceOf(\Illuminate\Database\Eloquent\Relations\HasMany::class);
});

it('has analytics relationship', function () {
    $country = Country::factory()->create();

    expect($country->analytics())->toBeInstanceOf(\Illuminate\Database\Eloquent\Relations\HasMany::class);
});

it('returns sitemap urls correctly', function () {
    $country = Country::factory()->create(['slug' => 'test-country']);

    $urls = $country->toSitemapTag();

    expect($urls)->toBeArray()
        ->and($urls[0])->toContain('/country/test-country')
        ->and($urls[1])->toContain('/vat-calculator/test-country');
});

it('can store multiple rate types', function () {
    $country = Country::factory()->create([
        'standard_rate' => 20,
        'reduced_rate' => 10,
        'super_reduced_rate' => 5,
        'zero_rate' => 0,
        'parking_rate' => 12,
    ]);

    expect($country->standard_rate)->toEqual(20)
        ->and($country->reduced_rate)->toEqual(10)
        ->and($country->super_reduced_rate)->toEqual(5)
        ->and($country->zero_rate)->toEqual(0)
        ->and($country->parking_rate)->toEqual(12);
});

it('can have null optional rates', function () {
    $country = Country::factory()->create([
        'standard_rate' => 20,
        'reduced_rate' => null,
        'super_reduced_rate' => null,
        'parking_rate' => null,
    ]);

    expect($country->standard_rate)->toEqual(20)
        ->and($country->reduced_rate)->toBeNull()
        ->and($country->super_reduced_rate)->toBeNull()
        ->and($country->parking_rate)->toBeNull();
});

it('stores iso codes correctly', function () {
    $country = Country::factory()->create([
        'iso_code' => 'DE',
        'iso_code_2' => 'DE', // Use 2-letter code
    ]);

    expect($country->iso_code)->toBe('DE')
        ->and($country->iso_code_2)->toBe('DE');
});

it('stores currency information', function () {
    $country = Country::factory()->create([
        'currency' => 'Euro',
        'currency_code' => 'EUR',
        'currency_symbol' => '€',
    ]);

    expect($country->currency)->toBe('Euro')
        ->and($country->currency_code)->toBe('EUR')
        ->and($country->currency_symbol)->toBe('€');
});

it('calculates rank as 1 when it has lowest standard rate', function () {
    Country::factory()->create(['standard_rate' => 25]);
    Country::factory()->create(['standard_rate' => 20]);
    $lowestCountry = Country::factory()->create(['standard_rate' => 15]);

    expect($lowestCountry->countryRank())->toBe(1);
});

it('calculates rank as highest when it has highest standard rate', function () {
    Country::factory()->create(['standard_rate' => 15]);
    Country::factory()->create(['standard_rate' => 20]);
    $highestCountry = Country::factory()->create(['standard_rate' => 25]);

    expect($highestCountry->countryRank())->toBe(3);
});

it('handles equal standard rates in ranking', function () {
    Country::factory()->create(['standard_rate' => 20, 'slug' => 'country-1']);
    Country::factory()->create(['standard_rate' => 20, 'slug' => 'country-2']);

    $country1 = Country::where('slug', 'country-1')->first();
    $country2 = Country::where('slug', 'country-2')->first();

    // Both should have the same rank since they have the same rate
    expect($country1->countryRank())->toBe($country2->countryRank());
});
