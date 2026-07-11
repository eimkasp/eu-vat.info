<?php

use App\Models\Country;
use App\Models\VatRate;
use App\Models\VatRateChange;

function seoCountry(array $overrides = []): Country
{
    return Country::factory()->create(array_merge([
        'name' => 'Germany',
        'slug' => 'germany',
        'iso_code' => 'DE',
        'standard_rate' => 19,
        'is_eu_member' => true,
    ], $overrides));
}

function seoChange(Country $country, array $overrides = []): VatRateChange
{
    return VatRateChange::factory()->create(array_merge([
        'country_id' => $country->id,
        'rate_type' => 'standard',
        'old_rate' => 18,
        'new_rate' => 19,
        'change_date' => '2026-01-01',
        'announced_date' => '2025-09-10',
        'description' => 'The standard VAT rate increased after the approved tax reform.',
        'change_reason' => 'Approved national tax reform',
        'source' => 'Federal Ministry of Finance',
        'source_url' => 'https://example.gov/vat-change',
        'change_direction' => 'increase',
    ], $overrides));
}

it('publishes a source-backed country VAT history', function () {
    $country = seoCountry();
    VatRate::create([
        'country_id' => $country->id,
        'type' => 'standard',
        'rate' => 18,
        'effective_from' => '2020-01-01',
        'effective_to' => '2025-12-31',
        'source' => 'Official archive',
    ]);
    seoChange($country);

    $this->get('/vat-rates/germany/history')
        ->assertOk()
        ->assertSee('<link rel="canonical" href="https://eu-vat.info/vat-rates/germany/history">', false)
        ->assertSee('Germany VAT rate history')
        ->assertSee('18.00%')
        ->assertSee('19.00%')
        ->assertSee('https://example.gov/vat-change')
        ->assertSee('/vat-changes/germany/standard/2026-01-01');
});

it('does not publish history pages for non-EU countries', function () {
    seoCountry(['name' => 'Switzerland', 'slug' => 'switzerland', 'iso_code' => 'CH', 'is_eu_member' => false]);

    $this->get('/vat-rates/switzerland/history')->assertNotFound();
});

it('does not publish an empty country VAT history page', function () {
    seoCountry();

    $this->get('/vat-rates/germany/history')->assertNotFound();
    $this->get('/sitemaps/changes.xml')->assertDontSee('/vat-rates/germany/history');
});

it('publishes one canonical page for a stored VAT change event', function () {
    $country = seoCountry();
    seoChange($country);

    $this->get('/vat-changes/germany/standard/2026-01-01')
        ->assertOk()
        ->assertSee('<link rel="canonical" href="https://eu-vat.info/vat-changes/germany/standard/2026-01-01">', false)
        ->assertSee('"@type":"Article"', false)
        ->assertSee('Federal Ministry of Finance')
        ->assertSee('Approved national tax reform')
        ->assertSee('/vat-rates/germany/history');

    $this->get('/vat-changes/germany/standard/2026-02-01')->assertNotFound();
});

it('publishes only year archives that contain VAT changes', function () {
    $country = seoCountry();
    seoChange($country);

    $this->get('/vat-changes/year/2026')
        ->assertOk()
        ->assertSee('VAT changes in 2026')
        ->assertSee('/vat-changes/germany/standard/2026-01-01');

    $this->get('/vat-changes/year/1999')->assertNotFound();
});

it('publishes an upcoming VAT changes archive from future records', function () {
    $country = seoCountry();
    seoChange($country, [
        'change_date' => now()->addYear()->startOfYear()->toDateString(),
    ]);

    $this->get('/vat-changes/upcoming')
        ->assertOk()
        ->assertSee('Upcoming EU VAT changes')
        ->assertSee($country->name);
});
