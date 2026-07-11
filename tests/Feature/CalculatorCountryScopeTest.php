<?php

use App\Models\Country;
use App\Models\VatRate;
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

it('discovers eligible non-EU calculators but keeps validators EU-only', function () {
    config()->set('calculator.additional_country_slugs', ['norway']);

    Country::factory()->create([
        'name' => 'Germany',
        'slug' => 'germany',
        'iso_code' => 'DE',
        'standard_rate' => 19,
        'is_eu_member' => true,
        'vies_available' => true,
    ]);
    Country::factory()->create([
        'name' => 'Norway',
        'slug' => 'norway',
        'iso_code' => 'NO',
        'standard_rate' => 25,
        'is_eu_member' => false,
        'vies_available' => false,
    ]);

    $this->get('/sitemaps/countries.xml')
        ->assertOk()
        ->assertSee('/vat-calculator/germany', false)
        ->assertSee('/vat-calculator/norway', false);

    $this->get('/sitemaps/validators.xml')
        ->assertOk()
        ->assertSee('/vat-number-validator/germany', false)
        ->assertDontSee('/vat-number-validator/norway', false);
});

it('uses scope-aware content and currency on a non-EU calculator page', function () {
    config()->set('calculator.additional_country_slugs', ['norway']);
    cache()->forget('hero_calc_countries_v3');
    cache()->forget('calculator_country_directory_v2');

    Country::factory()->create([
        'name' => 'Norway',
        'slug' => 'norway',
        'iso_code' => 'NO',
        'standard_rate' => 25,
        'currency_code' => 'NOK',
        'currency_symbol' => 'kr',
        'is_eu_member' => false,
        'vies_available' => false,
    ]);

    $this->get('/vat-calculator/norway')
        ->assertOk()
        ->assertSee('Other European country')
        ->assertSee('"priceCurrency":"NOK"', false)
        ->assertDontSee('Official European Commission data')
        ->assertDontSee('Validate Norway VAT Numbers')
        ->assertDontSee('VAT Rates Map');
});

it('keeps non-EU AMP calculator pages free of EU-only claims and history', function () {
    config()->set('calculator.additional_country_slugs', ['norway']);

    $norway = Country::factory()->create([
        'name' => 'Norway',
        'slug' => 'norway',
        'iso_code' => 'NO',
        'standard_rate' => 25,
        'currency_code' => 'NOK',
        'is_eu_member' => false,
        'vies_available' => false,
    ]);

    VatRate::create([
        'country_id' => $norway->id,
        'type' => 'standard',
        'rate' => 25,
        'effective_from' => now()->subYear(),
    ]);

    $this->get('/amp/vat-calculator/norway')
        ->assertOk()
        ->assertSee('Maintained VAT rate data')
        ->assertDontSee('All EU Rates')
        ->assertDontSee('VIES Available')
        ->assertDontSee('VAT Rate History')
        ->assertDontSee('European Commission');
});

it('excludes countries with blank slugs from calculator availability', function () {
    $country = Country::factory()->create([
        'name' => 'Blank Slug',
        'slug' => 'temporary-slug',
        'iso_code' => 'BS',
        'standard_rate' => 10,
        'is_eu_member' => true,
    ]);
    $country->newQuery()->whereKey($country)->update(['slug' => '']);

    expect(Country::calculatorAvailable()->whereKey($country)->exists())->toBeFalse();
});
