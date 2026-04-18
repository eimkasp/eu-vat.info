<?php

use App\Models\Country;
use App\Models\VatRateChange;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

// ── GET /api/x402/info (free, no payment required) ──────────────────────────

it('returns x402 protocol info', function () {
    $this->getJson('/api/x402/info')
        ->assertSuccessful()
        ->assertJsonPath('protocol', 'x402')
        ->assertJsonPath('version', 2)
        ->assertJsonStructure([
            'protocol',
            'version',
            'enabled',
            'docs',
            'description',
            'network',
            'facilitator',
            'endpoints',
            'free_endpoints',
        ]);
});

it('lists all configured x402 paid endpoints', function () {
    $response = $this->getJson('/api/x402/info');

    expect($response->json('endpoints'))->toHaveCount(3);
    expect($response->json('endpoints.0'))->toHaveKeys(['route', 'price', 'description']);
});

// ── x402 middleware disabled (default) ──────────────────────────────────────

it('serves donate endpoint without payment when x402 is disabled', function () {
    config(['x402.enabled' => false]);

    $this->getJson('/api/x402/donate')
        ->assertSuccessful()
        ->assertJsonPath('project', 'EU VAT Info');
});

it('serves premium vat-rates without payment when x402 is disabled', function () {
    config(['x402.enabled' => false]);

    Country::factory(3)->create();

    $this->getJson('/api/x402/premium/vat-rates')
        ->assertSuccessful()
        ->assertJsonStructure([
            'meta' => ['total_countries', 'last_updated', 'source', 'update_frequency'],
            'countries',
            'recent_changes',
        ]);
});

it('serves premium country data without payment when x402 is disabled', function () {
    config(['x402.enabled' => false]);

    Country::factory()->create(['slug' => 'germany', 'name' => 'Germany']);

    $this->getJson('/api/x402/premium/country/germany')
        ->assertSuccessful()
        ->assertJsonPath('country.slug', 'germany');
});

// ── x402 middleware enabled — returns 402 without payment ───────────────────

it('returns 402 Payment Required when x402 is enabled and no payment header', function () {
    config([
        'x402.enabled' => true,
        'x402.wallet_address' => '0xTestWalletAddress',
        'x402.network' => 'eip155:84532',
    ]);

    $response = $this->getJson('/api/x402/donate');

    $response->assertStatus(402);
    $response->assertHeader('PAYMENT-REQUIRED');
    $response->assertJsonPath('error', 'Payment Required');
});

it('returns correct x402 payment requirements in 402 response', function () {
    config([
        'x402.enabled' => true,
        'x402.wallet_address' => '0xTestWalletAddress',
        'x402.network' => 'eip155:84532',
    ]);

    $response = $this->getJson('/api/x402/donate');

    $paymentRequired = $response->json('x402');
    expect($paymentRequired['x402Version'])->toBe(2);
    expect($paymentRequired['accepts'])->toHaveCount(1);
    expect($paymentRequired['accepts'][0]['scheme'])->toBe('exact');
    expect($paymentRequired['accepts'][0]['payTo'])->toBe('0xTestWalletAddress');
    expect($paymentRequired['accepts'][0]['network'])->toBe('eip155:84532');
    expect($paymentRequired['accepts'][0]['asset'])->toBe('USDC');
});

it('returns 402 with correct atomic price for donate endpoint', function () {
    config([
        'x402.enabled' => true,
        'x402.wallet_address' => '0xTestWalletAddress',
    ]);

    $response = $this->getJson('/api/x402/donate');

    // $0.10 = 100000 atomic units (USDC has 6 decimals)
    expect($response->json('x402.accepts.0.maxAmountRequired'))->toBe('100000');
});

it('returns 402 for premium vat-rates when x402 enabled', function () {
    config([
        'x402.enabled' => true,
        'x402.wallet_address' => '0xTestWalletAddress',
    ]);

    $this->getJson('/api/x402/premium/vat-rates')
        ->assertStatus(402)
        ->assertHeader('PAYMENT-REQUIRED');
});

it('returns 402 for premium country when x402 enabled', function () {
    config([
        'x402.enabled' => true,
        'x402.wallet_address' => '0xTestWalletAddress',
    ]);

    Country::factory()->create(['slug' => 'germany']);

    $this->getJson('/api/x402/premium/country/germany')
        ->assertStatus(402)
        ->assertHeader('PAYMENT-REQUIRED');
});

// ── x402 does not affect free API routes ────────────────────────────────────

it('does not affect free API routes when x402 is enabled', function () {
    config([
        'x402.enabled' => true,
        'x402.wallet_address' => '0xTestWalletAddress',
    ]);

    Country::factory(2)->create();

    $this->getJson('/api/countries')
        ->assertSuccessful();
});

// ── PAYMENT-REQUIRED header is valid base64 JSON ────────────────────────────

it('returns valid base64-encoded JSON in PAYMENT-REQUIRED header', function () {
    config([
        'x402.enabled' => true,
        'x402.wallet_address' => '0xTestWalletAddress',
    ]);

    $response = $this->getJson('/api/x402/donate');

    $encoded = $response->headers->get('PAYMENT-REQUIRED');
    $decoded = json_decode(base64_decode($encoded), true);

    expect($decoded)->not->toBeNull();
    expect($decoded['x402Version'])->toBe(2);
    expect($decoded['accepts'])->toBeArray();
});

// ── Premium endpoints return enriched data ──────────────────────────────────

it('returns enriched data from premium vat-rates endpoint', function () {
    config(['x402.enabled' => false]);

    $country = Country::factory()->create(['name' => 'Germany', 'slug' => 'germany']);
    VatRateChange::factory()->create(['country_id' => $country->id]);

    $response = $this->getJson('/api/x402/premium/vat-rates');

    $response->assertSuccessful();
    expect($response->json('meta.total_countries'))->toBe(1);
    expect($response->json('countries'))->toHaveCount(1);
    expect($response->json('recent_changes'))->toHaveCount(1);
});

it('returns full country data from premium country endpoint', function () {
    config(['x402.enabled' => false]);

    $country = Country::factory()->create([
        'name' => 'Germany',
        'slug' => 'germany',
        'standard_rate' => 19,
    ]);

    $response = $this->getJson('/api/x402/premium/country/germany');

    $response->assertSuccessful();
    expect($response->json('country.name'))->toBe('Germany');
    expect($response->json('rates.standard'))->toBe(19);
    expect($response->json('rate_history'))->toBeArray();
    expect($response->json('meta'))->toHaveKeys(['updated_at', 'source', 'api_url', 'web_url']);
});

// ── GET /api root discovery endpoint ────────────────────────────────────────

it('returns API discovery index from /api root', function () {
    $this->getJson('/api')
        ->assertSuccessful()
        ->assertJsonPath('name', 'EU VAT Info API')
        ->assertJsonStructure([
            'name',
            'description',
            'documentation',
            'api_catalog',
            'endpoints',
            'x402' => ['info', 'protocol', 'version', 'network', 'enabled', 'endpoints'],
        ]);
});

it('includes x402 endpoints in /api root discovery', function () {
    $response = $this->getJson('/api');

    expect($response->json('x402.version'))->toBe(2);
    expect($response->json('x402.protocol'))->toBe('https://x402.org');
    expect($response->json('x402.endpoints'))->toHaveCount(3);
});

// ── x402 info endpoint includes full discovery fields ───────────────────────

it('includes payTo and asset in x402 info response', function () {
    config(['x402.wallet_address' => '0xTestWallet123']);

    $this->getJson('/api/x402/info')
        ->assertSuccessful()
        ->assertJsonPath('payTo', '0xTestWallet123')
        ->assertJsonPath('asset', 'USDC')
        ->assertJsonStructure(['donate_page']);
});

it('includes full URL in x402 info endpoint listings', function () {
    $response = $this->getJson('/api/x402/info');

    $endpoints = $response->json('endpoints');
    foreach ($endpoints as $endpoint) {
        expect($endpoint)->toHaveKeys(['route', 'url', 'price', 'description', 'mime_type']);
        expect($endpoint['url'])->toContain('/api/x402/');
    }
});

// ── 402 response includes CORS expose headers ───────────────────────────────

it('returns Access-Control-Expose-Headers on 402 response', function () {
    config([
        'x402.enabled' => true,
        'x402.wallet_address' => '0xTestWalletAddress',
    ]);

    $response = $this->getJson('/api/x402/donate');

    $response->assertStatus(402);
    $response->assertHeader('Access-Control-Expose-Headers', 'PAYMENT-REQUIRED, PAYMENT-RESPONSE');
});
