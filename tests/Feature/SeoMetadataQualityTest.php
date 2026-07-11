<?php

use App\Models\Country;
use App\Models\VatRateChange;
use Carbon\CarbonImmutable;

it('emits one canonical and avoids hard-coded year freshness claims on country calculators', function () {
    Country::factory()->create([
        'name' => 'Germany',
        'slug' => 'germany',
        'iso_code' => 'DE',
        'standard_rate' => 19,
        'is_eu_member' => true,
    ]);

    $response = $this->get('/vat-calculator/germany');
    $html = $response->getContent();

    $response->assertOk()->assertDontSee('Official 2026 data');
    expect(substr_count($html, '<link rel="canonical"'))->toBe(1)
        ->and(substr_count($html, '<meta property="og:url"'))->toBe(1);
});

it('limits popular calculation pages to EU members and writes a useful amount description', function () {
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

    $this->get('/top-vat-calculations/100')
        ->assertOk()
        ->assertSee('VAT on €100 across 1 EU member state')
        ->assertSee('standard rates from 19% to 19%')
        ->assertDontSee('Switzerland');
});

it('uses the latest stored change timestamp for VAT history dataset freshness', function () {
    $country = Country::factory()->create(['is_eu_member' => true]);
    $change = VatRateChange::factory()->create([
        'country_id' => $country->id,
        'change_date' => '2026-01-01',
    ]);
    $change->timestamps = false;
    $change->forceFill(['updated_at' => CarbonImmutable::parse('2026-06-05T10:00:00+00:00')])->saveQuietly();

    $this->get('/vat-changes')
        ->assertOk()
        ->assertSee('"dateModified":"2026-06-05T', false)
        ->assertDontSee('"dateModified":"'.now()->toDateString(), false);
});

it('keeps VAT history facets out of the index while preserving the canonical archive', function () {
    $country = Country::factory()->create(['is_eu_member' => true]);

    $this->get('/vat-changes?country='.$country->id.'&type=standard')
        ->assertOk()
        ->assertSee('<meta name="robots" content="noindex, follow">', false)
        ->assertSee('<link rel="canonical" href="https://eu-vat.info/vat-changes">', false);
});

it('includes finite programmatic pages in the changes and core sitemaps', function () {
    $country = Country::factory()->create([
        'name' => 'Germany',
        'slug' => 'germany',
        'iso_code' => 'DE',
        'is_eu_member' => true,
    ]);
    Country::factory()->create([
        'name' => 'France',
        'slug' => 'france',
        'iso_code' => 'FR',
        'is_eu_member' => true,
    ]);
    VatRateChange::factory()->create([
        'country_id' => $country->id,
        'rate_type' => 'standard',
        'change_date' => '2026-01-01',
    ]);

    $this->get('/sitemaps/changes.xml')
        ->assertOk()
        ->assertSee('/vat-rates/germany/history')
        ->assertSee('/vat-changes/germany/standard/2026-01-01')
        ->assertSee('/vat-changes/year/2026');

    $this->get('/sitemaps/core.xml')
        ->assertOk()
        ->assertSee('/datasets/eu-vat-rates')
        ->assertSee('/compare/germany-vs-france-vat');
});
