<?php

use App\Models\Country;
use App\Models\VatRateChange;
use App\Services\Seo\InternalLinkService;

function comparisonCountry(string $name, string $slug, string $iso, float $rate): Country
{
    return Country::factory()->create([
        'name' => $name,
        'slug' => $slug,
        'iso_code' => $iso,
        'standard_rate' => $rate,
        'is_eu_member' => true,
    ]);
}

it('publishes only allowlisted VAT country comparisons', function () {
    $germany = comparisonCountry('Germany', 'germany', 'DE', 19);
    $france = comparisonCountry('France', 'france', 'FR', 20);
    VatRateChange::factory()->for($germany)->create();
    VatRateChange::factory()->for($france)->create();

    $this->get('/compare/germany-vs-france-vat')
        ->assertOk()
        ->assertSee('<link rel="canonical" href="https://eu-vat.info/compare/germany-vs-france-vat">', false)
        ->assertSee('Germany vs France VAT rates')
        ->assertSee('19.00%')
        ->assertSee('20.00%')
        ->assertSee('/vat-rates/germany/history')
        ->assertSee('/vat-rates/france/history');

    $this->get('/compare/germany-vs-hungary-vat')->assertNotFound();
});

it('redirects a reversed approved comparison to one canonical order', function () {
    comparisonCountry('Germany', 'germany', 'DE', 19);
    comparisonCountry('France', 'france', 'FR', 20);

    $this->get('/compare/france-vs-germany-vat')
        ->assertRedirect('/compare/germany-vs-france-vat')
        ->assertStatus(301);
});

it('returns not found when an approved comparison country is unavailable', function () {
    comparisonCountry('Germany', 'germany', 'DE', 19);

    $this->get('/compare/germany-vs-france-vat')->assertNotFound();
});

it('selects related countries by VAT-rate relevance instead of alphabetically', function () {
    $germany = comparisonCountry('Germany', 'germany', 'DE', 19);
    comparisonCountry('Austria', 'austria', 'AT', 20);
    comparisonCountry('France', 'france', 'FR', 20);
    comparisonCountry('Netherlands', 'netherlands', 'NL', 21);
    comparisonCountry('Hungary', 'hungary', 'HU', 27);

    $related = app(InternalLinkService::class)->relatedCountries($germany, 3);

    expect($related->pluck('slug')->all())->toBe(['austria', 'france', 'netherlands']);
});

it('links country hubs to history and approved comparisons', function () {
    $germany = comparisonCountry('Germany', 'germany', 'DE', 19);
    comparisonCountry('France', 'france', 'FR', 20);
    VatRateChange::factory()->for($germany)->create();

    $this->get('/vat-calculator/germany')
        ->assertOk()
        ->assertSee('/vat-rates/germany/history')
        ->assertSee('/compare/germany-vs-france-vat');
});

it('does not link to a country history without stored historical data', function () {
    comparisonCountry('Germany', 'germany', 'DE', 19);
    comparisonCountry('France', 'france', 'FR', 20);

    $this->get('/vat-calculator/germany')
        ->assertOk()
        ->assertDontSee('/vat-rates/germany/history');
});
