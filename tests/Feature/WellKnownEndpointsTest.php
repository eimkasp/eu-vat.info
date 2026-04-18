<?php

use Illuminate\Support\Facades\Storage;

// ── Web Bot Auth: /.well-known/http-message-signatures-directory ────────────

it('serves the http-message-signatures-directory endpoint', function () {
    // Generate keys so the endpoint has data
    $this->artisan('bot-auth:generate-keys', ['--force' => true])
        ->assertSuccessful();

    $this->get('/.well-known/http-message-signatures-directory')
        ->assertSuccessful()
        ->assertJsonStructure(['keys'])
        ->assertHeader('Cache-Control');
});

it('returns a JWKS with at least one key when keys are generated', function () {
    $this->artisan('bot-auth:generate-keys', ['--force' => true]);

    $response = $this->getJson('/.well-known/http-message-signatures-directory');

    $keys = $response->json('keys');
    expect($keys)->toHaveCount(1);
    expect($keys[0])->toHaveKeys(['kty', 'crv', 'x', 'y', 'kid', 'use', 'alg']);
    expect($keys[0]['kty'])->toBe('EC');
    expect($keys[0]['crv'])->toBe('P-256');
    expect($keys[0]['alg'])->toBe('ES256');
});

it('returns empty JWKS when no keys have been generated', function () {
    Storage::disk('local')->delete('bot-auth/public-key.json');

    $response = $this->getJson('/.well-known/http-message-signatures-directory');

    $response->assertSuccessful();
    expect($response->json('keys'))->toBeEmpty();
});

it('does not expose the private key in the signatures directory', function () {
    $this->artisan('bot-auth:generate-keys', ['--force' => true]);

    $response = $this->getJson('/.well-known/http-message-signatures-directory');

    $keys = $response->json('keys');
    expect($keys[0])->not->toHaveKey('d');
});

// ── JWKS endpoint shares the same keys ──────────────────────────────────────

it('serves JWKS at /.well-known/jwks.json with the same keys', function () {
    $this->artisan('bot-auth:generate-keys', ['--force' => true]);

    $sigDir = $this->getJson('/.well-known/http-message-signatures-directory')->json();
    $jwks = $this->getJson('/.well-known/jwks.json')->json();

    expect($jwks)->toEqual($sigDir);
});

// ── OAuth Protected Resource Metadata: /.well-known/oauth-protected-resource

it('serves OAuth Protected Resource Metadata per RFC 9728', function () {
    $response = $this->getJson('/.well-known/oauth-protected-resource');

    $response->assertSuccessful()
        ->assertJsonStructure([
            'resource',
            'authorization_servers',
            'scopes_supported',
            'bearer_methods_supported',
            'resource_documentation',
            'jwks_uri',
        ]);
});

it('has authorization_servers pointing to the issuer URL', function () {
    $response = $this->getJson('/.well-known/oauth-protected-resource');

    $baseUrl = config('app.url');
    $servers = $response->json('authorization_servers');

    expect($servers)->toBe([$baseUrl]);
});

it('includes signing algorithm support', function () {
    $response = $this->getJson('/.well-known/oauth-protected-resource');

    expect($response->json('resource_signing_alg_values_supported'))->toContain('ES256');
});

it('includes jwks_uri in protected resource metadata', function () {
    $response = $this->getJson('/.well-known/oauth-protected-resource');

    $baseUrl = config('app.url');
    expect($response->json('jwks_uri'))->toBe($baseUrl . '/.well-known/jwks.json');
});

it('includes MCP server info in protected resource metadata', function () {
    $response = $this->getJson('/.well-known/oauth-protected-resource');

    expect($response->json('mcp.endpoint'))->toEndWith('/api/mcp');
    expect($response->json('mcp.transport'))->toBe('http-json-rpc');
});

// ── Key generation command ──────────────────────────────────────────────────

it('generates bot auth keys via artisan command', function () {
    Storage::disk('local')->delete('bot-auth/public-key.json');
    Storage::disk('local')->delete('bot-auth/private-key.pem');
    Storage::disk('local')->delete('bot-auth/private-key.json');

    $this->artisan('bot-auth:generate-keys')
        ->expectsOutput('Bot auth keys generated successfully.')
        ->assertSuccessful();

    expect(Storage::disk('local')->exists('bot-auth/public-key.json'))->toBeTrue();
    expect(Storage::disk('local')->exists('bot-auth/private-key.pem'))->toBeTrue();
    expect(Storage::disk('local')->exists('bot-auth/private-key.json'))->toBeTrue();
});

it('does not overwrite existing keys without --force', function () {
    $this->artisan('bot-auth:generate-keys', ['--force' => true]);

    $original = Storage::disk('local')->get('bot-auth/public-key.json');

    $this->artisan('bot-auth:generate-keys')
        ->expectsOutput('Bot auth keys already exist. Use --force to regenerate.')
        ->assertSuccessful();

    expect(Storage::disk('local')->get('bot-auth/public-key.json'))->toBe($original);
});

it('overwrites keys when --force is used', function () {
    $this->artisan('bot-auth:generate-keys', ['--force' => true]);
    $original = Storage::disk('local')->get('bot-auth/public-key.json');

    $this->artisan('bot-auth:generate-keys', ['--force' => true]);
    $regenerated = Storage::disk('local')->get('bot-auth/public-key.json');

    // Keys should be different (new random key pair)
    expect($regenerated)->not->toBe($original);
});

it('stores private key with d parameter in private-key.json', function () {
    $this->artisan('bot-auth:generate-keys', ['--force' => true]);

    $privateJwk = json_decode(Storage::disk('local')->get('bot-auth/private-key.json'), true);

    expect($privateJwk)->toHaveKeys(['kty', 'crv', 'x', 'y', 'd', 'kid', 'alg']);
    expect($privateJwk['d'])->not->toBeEmpty();
});
