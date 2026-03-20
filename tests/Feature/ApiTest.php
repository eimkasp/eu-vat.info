<?php

use App\Models\Country;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

// ── GET /api/countries ────────────────────────────────────────────────────────

it('returns a JSON list of countries from the API', function () {
    Country::factory(3)->create();

    $this->getJson('/api/countries')
        ->assertSuccessful()
        ->assertJsonStructure([
            'data' => [
                '*' => ['id', 'name', 'slug', 'rates', 'links', 'last_updated'],
            ],
        ]);
});

it('returns all persisted countries in the API list', function () {
    Country::factory()->create(['name' => 'Germany', 'slug' => 'germany']);
    Country::factory()->create(['name' => 'France', 'slug' => 'france']);

    $response = $this->getJson('/api/countries')
        ->assertSuccessful();

    expect($response->json('data'))->toHaveCount(2);
});

// ── GET /api/countries/{slug} ─────────────────────────────────────────────────

it('returns a single country by slug from the API', function () {
    Country::factory()->create([
        'name' => 'Germany',
        'slug' => 'germany',
        'iso_code' => 'DE',
        'standard_rate' => 19,
    ]);

    $this->getJson('/api/countries/germany')
        ->assertSuccessful()
        ->assertJsonPath('data.slug', 'germany')
        ->assertJsonPath('data.rates.standard', 19);
});

it('returns 404 for an unknown country slug', function () {
    $this->getJson('/api/countries/non-existent-country')
        ->assertNotFound();
});

// ── GET /api/vat/validation/health ───────────────────────────────────────────

it('returns operational status from the health endpoint', function () {
    $this->getJson('/api/vat/validation/health')
        ->assertSuccessful()
        ->assertJsonPath('status', 'operational');
});

// ── POST /api/vat/validation/validate ────────────────────────────────────────

it('returns validation errors when required fields are missing', function () {
    $this->postJson('/api/vat/validation/validate', [])
        ->assertUnprocessable()
        ->assertJsonValidationErrors(['country_code', 'vat_number']);
});

it('returns validation error when country_code is not exactly 2 characters', function () {
    $this->postJson('/api/vat/validation/validate', [
        'country_code' => 'DEU',
        'vat_number' => 'DE123456789',
    ])->assertUnprocessable()
      ->assertJsonValidationErrors(['country_code']);
});

// ── GET /api/llm/vat-rates ───────────────────────────────────────────────────

it('returns LLM-ready VAT rate data for all countries', function () {
    Country::factory()->create([
        'name' => 'Germany',
        'slug' => 'germany',
        'iso_code' => 'DE',
        'standard_rate' => 19,
    ]);

    $this->getJson('/api/llm/vat-rates')
        ->assertSuccessful()
        ->assertJsonStructure([
            '*' => ['country', 'iso', 'rates', 'last_updated'],
        ]);
});
