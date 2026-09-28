<?php

use App\Models\Country;
use App\Support\EuropeMapSvg;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

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

// ── /vat-changes route is enabled (VAT History page) ──────────────────────

it('loads vat-changes history page', function () {
    $response = $this->get('/vat-changes');
    $response->assertStatus(200);
    $response->assertSee('VAT Rate Changes History');
});

it('does not show vat changelog link in header', function () {
    $response = $this->get('/');
    $response->assertStatus(200);
    $response->assertDontSee('VAT Changelog');
});

it('shows vat rate history link in footer', function () {
    $response = $this->get('/');
    $response->assertStatus(200);
    expect($response->getContent())->toContain('VAT Rate History');
});

// ── VAT Map improvements ───────────────────────────────────────────────────

it('loads the vat map page successfully', function () {
    $this->get('/vat-map')
        ->assertStatus(200)
        ->assertSee('European VAT Rates Map')
        ->assertSee('class="eu-map"', false)
        ->assertSee('data-iso="DE"', false);
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

it('renders an accessible choropleth with a colour bucket per country', function () {
    $svg = EuropeMapSvg::render(Country::query()->get(), 'map-title');

    expect($svg)
        ->toContain('aria-labelledby="map-title"')
        ->toContain('data-iso="HU"')
        ->toContain('class="eu-map-region eu-map-b4"')
        ->toContain('aria-label="Germany, Standard 19%"')
        ->toContain('role="button"')
        ->and(EuropeMapSvg::bucket(17))->toBe(0)
        ->and(EuropeMapSvg::bucket(21.5))->toBe(2)
        ->and(EuropeMapSvg::bucket(27))->toBe(4);
});

it('vat map page has calculator links in table', function () {
    $this->get('/vat-map')
        ->assertStatus(200)
        ->assertSee('href="/vat-calculator/germany"', false)
        ->assertSee('Calculator');
});

// ── Calculator compactness (view assertions) ───────────────────────────────

it('calculator page renders with compact layout', function () {
    $this->get('/vat-calculator')
        ->assertStatus(200)
        ->assertSee('VAT Calculator')
        ->assertSee('Add VAT')
        ->assertSee('Remove VAT');
});

it('html sitemap page includes vat history link', function () {
    $this->get('/sitemap')
        ->assertStatus(200)
        ->assertSee('Sitemap')
        ->assertSee('VAT Rate History');
});

// ── XML sitemap is valid and accessible ─────────────────────────────────────

it('xml sitemap is accessible and contains valid xml', function () {
    $response = $this->get('/sitemap.xml');
    $response->assertStatus(200);
    expect($response->getContent())->toContain('<?xml version="1.0"');
});

// ── robots.txt and llms.txt exclude vat-changes ────────────────────────────

it('robots txt does not reference vat-changes', function () {
    $content = file_get_contents(public_path('robots.txt'));
    expect($content)->not->toContain('vat-changes');
});

it('llms txt references vat-changes history page', function () {
    $this->get('/llms.txt')
        ->assertOk()
        ->assertSee('/vat-changes')
        ->assertSee('VAT rate changes');
});
