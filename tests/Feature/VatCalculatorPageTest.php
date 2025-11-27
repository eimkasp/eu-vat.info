<?php

use App\Models\Country;

beforeEach(function () {
    // Create test countries
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
});

it('loads the main vat calculator page', function () {
    $this->get('/vat-calculator')
        ->assertStatus(200)
        ->assertSee('European')
        ->assertSee('VAT Calculator')
        ->assertSee('Calculate VAT');
});

it('loads country specific calculator page', function () {
    $country = Country::where('slug', 'germany')->first();
    
    $this->get("/vat-calculator/{$country->slug}")
        ->assertStatus(200)
        ->assertSee($country->name . ' VAT Calculator')
        ->assertSee('Current standard rate is')
        ->assertSee($country->standard_rate . '%');
});

it('displays current vat rates section on country page', function () {
    $country = Country::where('slug', 'germany')->first();
    
    $this->get("/vat-calculator/{$country->slug}")
        ->assertStatus(200)
        ->assertSee('Current VAT Rates')
        ->assertSee($country->standard_rate . '%');
});

it('displays link to country guide', function () {
    $country = Country::where('slug', 'germany')->first();
    
    $this->get("/vat-calculator/{$country->slug}")
        ->assertStatus(200)
        ->assertSee('Need more details?')
        ->assertSee('View ' . $country->name . ' VAT Guide');
});

it('returns 404 for invalid country slug', function () {
    $this->get('/vat-calculator/invalid-country-slug')
        ->assertStatus(404);
});

it('displays breadcrumbs on main calculator page', function () {
    $this->get('/vat-calculator')
        ->assertStatus(200)
        ->assertSee('VAT Calculator');
});

it('displays breadcrumbs on country calculator page', function () {
    $country = Country::where('slug', 'france')->first();
    
    $this->get("/vat-calculator/{$country->slug}")
        ->assertStatus(200)
        ->assertSee('VAT Calculator')
        ->assertSee($country->name);
});

it('shows multiple vat rates for country with reduced rates', function () {
    $country = Country::where('slug', 'france')->first();
    
    $this->get("/vat-calculator/{$country->slug}")
        ->assertStatus(200)
        ->assertSee('Current VAT Rates')
        ->assertSee($country->standard_rate . '%')
        ->assertSee($country->reduced_rate . '%')
        ->assertSee($country->super_reduced_rate . '%');
});

it('displays europe map component', function () {
    $this->get('/vat-calculator')
        ->assertStatus(200)
        ->assertSeeLivewire('europe-map');
});

it('displays vat calculator form component', function () {
    $this->get('/vat-calculator')
        ->assertStatus(200)
        ->assertSeeLivewire('vat-calculator-form');
});

it('displays saved searches component', function () {
    $this->get('/vat-calculator')
        ->assertStatus(200);
});

it('has proper seo meta tags on country page', function () {
    $country = Country::where('slug', 'germany')->first();
    
    $this->get("/vat-calculator/{$country->slug}")
        ->assertStatus(200)
        ->assertSee('VAT Calculator - ' . $country->name, false)
        ->assertSee('Calculate VAT for ' . $country->name, false);
});

it('displays schema.org json-ld on country page', function () {
    $country = Country::where('slug', 'france')->first();
    
    $response = $this->get("/vat-calculator/{$country->slug}")
        ->assertStatus(200);
        
    expect($response->getContent())
        ->toContain('application/ld+json')
        ->toContain('WebApplication')
        ->toContain($country->name . ' VAT Calculator');
});
