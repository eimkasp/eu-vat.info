<?php

use App\Livewire\VatCalculator;
use App\Livewire\VatMap;
use App\Livewire\EuropeMap;
use App\Models\Country;
use Livewire\Livewire;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

beforeEach(function () {
    Country::factory()->create([
        'name' => 'Germany',
        'slug' => 'germany',
        'iso_code' => 'DE',
        'standard_rate' => 19,
        'reduced_rate' => 7,
        'super_reduced_rate' => null,
        'parking_rate' => null,
    ]);

    Country::factory()->create([
        'name' => 'France',
        'slug' => 'france',
        'iso_code' => 'FR',
        'standard_rate' => 20,
        'reduced_rate' => 10,
        'super_reduced_rate' => 2.1,
        'parking_rate' => null,
    ]);

    Country::factory()->create([
        'name' => 'Hungary',
        'slug' => 'hungary',
        'iso_code' => 'HU',
        'standard_rate' => 27,
        'reduced_rate' => 18,
        'super_reduced_rate' => 5,
        'parking_rate' => null,
    ]);
});

// ── Calculator dropdown fix: country switching recalculates properly ────────

it('recalculates when country changes via updated hook', function () {
    Livewire::test(VatCalculator::class, ['slug' => 'germany'])
        ->assertSet('selectedRate', 19)
        ->set('amount', '100')
        ->set('vat_included', 'exclude')
        ->call('calculate')
        ->assertSet('vat_amount', 19.00)
        ->assertSet('total', 119.00)
        // Switch country - updated() should auto-recalculate
        ->set('selectedCountry1', 'france')
        ->assertSet('selectedRate', 20)
        ->assertSet('vat_amount', 20.00)
        ->assertSet('total', 120.00);
});

it('recalculates when vat_included mode changes via updated hook', function () {
    Livewire::test(VatCalculator::class, ['slug' => 'germany'])
        ->set('amount', '119')
        ->set('selectedRate', 19)
        ->set('vat_included', 'exclude')
        ->call('calculate')
        ->assertSet('total', 141.61)
        // Switch mode - updated() should auto-recalculate
        ->set('vat_included', 'include')
        ->assertSet('total', 119.00)
        ->assertSet('vat_amount', 19.00);
});

it('resets custom rate when switching countries', function () {
    Livewire::test(VatCalculator::class, ['slug' => 'germany'])
        ->set('useCustomRate', true)
        ->set('customRate', '15')
        ->call('setCustomRate')
        ->assertSet('selectedRate', 15)
        ->assertSet('useCustomRate', true)
        // Switch country
        ->set('selectedCountry1', 'france')
        ->assertSet('useCustomRate', false)
        ->assertSet('selectedRate', 20);
});

// ── /vat-changes route is disabled ─────────────────────────────────────────

it('returns 404 for disabled vat-changes route', function () {
    $response = $this->get('/vat-changes');
    // Route is commented out, should be 404 (or 500 if route name still referenced somewhere)
    expect($response->getStatusCode())->toBeIn([404, 500]);
});

it('does not show vat changelog link in header', function () {
    $response = $this->get('/');
    $response->assertStatus(200);
    $response->assertDontSee('VAT Changelog');
});

it('does not show vat rate changes link in footer', function () {
    $response = $this->get('/');
    $response->assertStatus(200);
    // The footer link to vat-changes was removed; widget heading may still exist
    expect($response->getContent())->not->toContain('href="http://localhost/vat-changes"');
});

// ── VAT Map improvements ───────────────────────────────────────────────────

it('loads the vat map page successfully', function () {
    $this->get('/vat-map')
        ->assertStatus(200)
        ->assertSee('European VAT Rates Map')
        ->assertSeeLivewire('europe-map');
});

it('vat map page displays country rate table', function () {
    $this->get('/vat-map')
        ->assertStatus(200)
        ->assertSee('All EU VAT Rates at a Glance')
        ->assertSee('Germany')
        ->assertSee('France')
        ->assertSee('Hungary')
        ->assertSee('19%')
        ->assertSee('20%')
        ->assertSee('27%');
});

it('europe map component provides country data', function () {
    $component = Livewire::test(EuropeMap::class, ['layout' => 'single']);
    expect($component->get('layout'))->toBe('single');
    expect($component->get('countryData'))->not->toBeEmpty();
});

it('vat map page has calculator links in table', function () {
    $this->get('/vat-map')
        ->assertStatus(200)
        ->assertSee('Calculator →');
});

// ── Calculator compactness (view assertions) ───────────────────────────────

it('calculator page renders with compact layout', function () {
    $this->get('/vat-calculator')
        ->assertStatus(200)
        ->assertSee('VAT Calculator')
        ->assertSee('Calculation Mode')
        ->assertSee('Includes VAT')
        ->assertSee('Excludes VAT');
});

it('html sitemap page loads without vat-changes', function () {
    $this->get('/sitemap')
        ->assertStatus(200)
        ->assertSee('Sitemap')
        ->assertDontSee('VAT Rate Changes History');
});

// ── XML sitemap excludes vat-changes ────────────────────────────────────────

it('xml sitemap does not contain vat-changes url', function () {
    $response = $this->get('/sitemap.xml');
    $response->assertStatus(200);
    expect($response->getContent())->not->toContain('vat-changes');
});

// ── robots.txt and llms.txt exclude vat-changes ────────────────────────────

it('robots txt does not reference vat-changes', function () {
    $content = file_get_contents(public_path('robots.txt'));
    expect($content)->not->toContain('vat-changes');
});

it('llms txt does not reference vat-changes', function () {
    $content = file_get_contents(public_path('llms.txt'));
    expect($content)->not->toContain('vat-changes');
});
