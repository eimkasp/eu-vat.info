<?php

use App\Models\Country;
use Database\Seeders\CountriesTableSeeder;

it('seeds a working site with every EU member state flagged for VIES', function () {
    $this->seed(CountriesTableSeeder::class);

    expect(Country::query()->where('is_eu_member', true)->orderBy('iso_code')->pluck('iso_code')->all())
        ->toBe(collect(Country::EU_MEMBER_CODES)->sort()->values()->all())
        ->and(Country::query()->where('vies_available', true)->count())->toBe(count(Country::EU_MEMBER_CODES))
        ->and(Country::query()->where('iso_code', 'NO')->firstOrFail()->is_eu_member)->toBeFalse();

    $this->get('/vat-calculator/germany')->assertOk();
    $this->getJson(route('vat-dataset.json'))->assertOk()->assertJsonCount(count(Country::EU_MEMBER_CODES), 'data');
});
