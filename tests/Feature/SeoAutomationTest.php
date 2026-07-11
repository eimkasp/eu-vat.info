<?php

use App\Services\Seo\IndexNowService;
use Illuminate\Support\Facades\Http;

afterEach(function () {
    \Livewire\Features\SupportDisablingBackButtonCache\SupportDisablingBackButtonCache::$disableBackButtonCache = false;
});

it('keeps IndexNow disabled until credentials are configured', function () {
    Http::fake();
    config()->set('seo.indexnow.enabled', false);

    expect(app(IndexNowService::class)->submit(['https://vat.businesspress.io/vat-changes']))->toBeFalse();
    Http::assertNothingSent();
});

it('submits only canonical-host URLs in an IndexNow payload', function () {
    Http::fake(['https://api.indexnow.org/indexnow' => Http::response('', 200)]);
    config()->set('seo.indexnow.enabled', true);
    config()->set('seo.indexnow.key', 'seo-test-key');

    $result = app(IndexNowService::class)->submit([
        'https://vat.businesspress.io/vat-changes',
        'https://vat.businesspress.io/vat-changes',
        'https://example.com/not-ours',
    ]);

    expect($result)->toBeTrue();
    Http::assertSent(fn ($request) => $request->url() === 'https://api.indexnow.org/indexnow'
        && $request['host'] === 'vat.businesspress.io'
        && $request['key'] === 'seo-test-key'
        && $request['keyLocation'] === 'https://vat.businesspress.io/indexnow-key.txt'
        && $request['urlList'] === ['https://vat.businesspress.io/vat-changes']);
});

it('serves the configured IndexNow key only when enabled', function () {
    config()->set('seo.indexnow.enabled', true);
    config()->set('seo.indexnow.key', 'seo-test-key');

    $this->get('/indexnow-key.txt')
        ->assertOk()
        ->assertSeeText('seo-test-key');

    config()->set('seo.indexnow.enabled', false);
    \Livewire\Features\SupportDisablingBackButtonCache\SupportDisablingBackButtonCache::$disableBackButtonCache = true;
    $response = $this->get('/indexnow-key.txt')->assertNotFound();

    expect($response->headers->get('Cache-Control'))->not->toContain('public');
});

it('passes the repository SEO audit and rejects legacy canonical configuration', function () {
    $this->artisan('seo:audit')->assertSuccessful();

    config()->set('seo.canonical_url', 'https://eu-vat.info');
    $this->artisan('seo:audit')->assertFailed();
});
