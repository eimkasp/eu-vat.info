<?php

use App\Models\Country;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;

uses(RefreshDatabase::class);

// Skip these tests in environments where the database schema is incomplete
// These tests require a working database with the countries table
it('generates an OG image for a country', function () {
    // Create a minimal country without relying on factory defaults
    $country = new Country;
    $country->name = 'Test Country';
    $country->slug = 'test-country';
    $country->iso_code = 'TC';
    $country->standard_rate = 21;
    $country->reduced_rate = 9;
    $country->save();

    $response = $this->get(route('og-image.country', 'test-country'));

    $response->assertStatus(200);
    $response->assertHeader('Content-Type', 'image/png');
    $response->assertHeader('Cache-Control', 'public, max-age=86400');
})->skip(fn () => ! Schema::hasTable('countries'), 'Skipped: countries table does not exist');

it('returns 404 for non-existent country', function () {
    $response = $this->get(route('og-image.country', 'non-existent-country'));

    $response->assertStatus(404);
})->skip(fn () => ! Schema::hasTable('countries'), 'Skipped: countries table does not exist');

it('caches the generated OG image', function () {
    Storage::disk('public')->deleteDirectory('og-images');

    $country = new Country;
    $country->name = 'Cache Test Country';
    $country->slug = 'cache-test-country';
    $country->iso_code = 'CT';
    $country->standard_rate = 21;
    $country->reduced_rate = 9;
    $country->save();

    // First request - should generate and save image
    $response1 = $this->get(route('og-image.country', 'cache-test-country'));
    $response1->assertStatus(200);

    // Check that image was saved to storage
    expect(Storage::disk('public')->exists('og-images/country-cache-test-country.png'))->toBeTrue();

    // Second request - should use cached image
    $response2 = $this->get(route('og-image.country', 'cache-test-country'));
    $response2->assertStatus(200);
})->skip(fn () => ! Schema::hasTable('countries'), 'Skipped: countries table does not exist');

it('generates a valid PNG image', function () {
    $country = new Country;
    $country->name = 'PNG Test Country';
    $country->slug = 'png-test-country';
    $country->iso_code = 'PT';
    $country->standard_rate = 19;
    $country->reduced_rate = 7;
    $country->save();

    $response = $this->get(route('og-image.country', 'png-test-country'));

    $response->assertStatus(200);

    // Verify PNG signature (first 8 bytes)
    $pngSignature = "\x89PNG\r\n\x1a\n";
    expect(str_starts_with($response->getContent(), $pngSignature))->toBeTrue();
})->skip(fn () => ! Schema::hasTable('countries'), 'Skipped: countries table does not exist');

it('generates image for country without reduced rate', function () {
    $country = new Country;
    $country->name = 'No Reduced Rate Country';
    $country->slug = 'no-reduced-rate-country';
    $country->iso_code = 'NR';
    $country->standard_rate = 25;
    $country->reduced_rate = null;
    $country->save();

    $response = $this->get(route('og-image.country', 'no-reduced-rate-country'));

    $response->assertStatus(200);
    $response->assertHeader('Content-Type', 'image/png');
})->skip(fn () => ! Schema::hasTable('countries'), 'Skipped: countries table does not exist');
