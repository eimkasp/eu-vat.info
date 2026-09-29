<?php

use App\Models\Country;
use Illuminate\Support\Facades\Http;

beforeEach(function () {
    Country::factory()->create([
        'name' => 'Bulgaria', 'slug' => 'bulgaria', 'iso_code' => 'BG',
        'currency' => 'Euro', 'currency_code' => 'EUR', 'currency_symbol' => '€',
    ]);
    Country::factory()->create([
        'name' => 'Hungary', 'slug' => 'hungary', 'iso_code' => 'HU',
        'currency' => null, 'currency_code' => null, 'currency_symbol' => null,
    ]);
});

it('keeps curated currencies when the countries API lags behind a changeover', function (string $command, array $options) {
    Http::fake(['restcountries.com/*' => Http::response([
        ['cca2' => 'BG', 'currencies' => ['BGN' => ['name' => 'Bulgarian lev', 'symbol' => 'лв']]],
        ['cca2' => 'HU', 'currencies' => ['EUR' => ['name' => 'Euro', 'symbol' => '€'], 'HUF' => ['name' => 'Hungarian forint', 'symbol' => 'Ft']]],
    ])]);

    $this->artisan($command, $options)->assertSuccessful();

    expect(Country::query()->where('iso_code', 'BG')->first())
        ->currency_code->toBe('EUR')
        ->currency_symbol->toBe('€')
        ->and(Country::query()->where('iso_code', 'HU')->first())
        ->currency_code->toBe('HUF')
        ->currency_symbol->toBe('Ft');
})->with([
    'data:sync' => ['data:sync', ['--skip-rates' => true, '--skip-changes' => true]],
    'countries:validate' => ['countries:validate', ['--fix' => true]],
]);

it('derives currency codes and symbols when the database leaves them empty', function () {
    $unitedKingdom = Country::factory()->create([
        'name' => 'United Kingdom', 'slug' => 'united-kingdom', 'iso_code' => 'GB', 'is_eu_member' => false,
        'vies_available' => false, 'currency' => null, 'currency_code' => null, 'currency_symbol' => null,
    ]);

    expect($unitedKingdom->currencyCode())->toBe('GBP')
        ->and($unitedKingdom->currency_display)->toBe('£')
        ->and(Country::query()->where('iso_code', 'HU')->first()->currency_display)->toBe('Ft');

    $this->getJson(route('vat-dataset.json'))
        ->assertOk()
        ->assertJsonFragment(['iso_code' => 'HU', 'currency_code' => 'HUF']);
});
