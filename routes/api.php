<?php

use App\Http\Controllers\Api\CountryRatesController;
use App\Http\Controllers\Api\McpController;
use App\Http\Controllers\Api\VatValidationController;
use App\Http\Controllers\Api\X402Controller;
use App\Http\Controllers\CountryController;
use App\Models\Country;
use Illuminate\Support\Facades\Route;

// API root — discovery index for all available endpoints
Route::get('/', function () {
    $baseUrl = rtrim(config('app.url'), '/');

    return response()->json([
        'name' => 'EU VAT Info API',
        'description' => 'Free, open-source EU VAT data for developers, businesses, and AI agents.',
        'documentation' => $baseUrl . '/llms.txt',
        'api_catalog' => $baseUrl . '/.well-known/api-catalog',
        'endpoints' => [
            'countries'       => $baseUrl . '/api/countries',
            'country'         => $baseUrl . '/api/countries/{slug}',
            'llm_vat_rates'   => $baseUrl . '/api/llm/vat-rates',
            'vat_changes'     => $baseUrl . '/api/vat-changes',
            'vat_validate'    => $baseUrl . '/api/vat/validation/validate',
            'vat_batch'       => $baseUrl . '/api/vat/validation/batch',
            'health'          => $baseUrl . '/api/vat/validation/health',
            'mcp'             => $baseUrl . '/api/mcp',
        ],
        'x402' => [
            'info'       => $baseUrl . '/api/x402/info',
            'protocol'   => 'https://x402.org',
            'version'    => 2,
            'network'    => config('x402.network'),
            'enabled'    => (bool) config('x402.enabled', false),
            'endpoints'  => collect(config('x402.routes', []))->map(fn ($cfg, $route) => [
                'route'       => $route,
                'url'         => $baseUrl . '/' . ltrim(explode(' ', $route, 2)[1] ?? '', '/'),
                'price'       => $cfg['price'],
                'description' => $cfg['description'],
            ])->values(),
        ],
    ]);
})->name('api.index');

// VAT Validation API
Route::prefix('vat/validation')->group(function () {
    Route::post('/validate', [VatValidationController::class, 'validate'])->name('api.vat.validate');
    Route::post('/batch', [VatValidationController::class, 'batchValidate'])->name('api.vat.batch');
    Route::get('/health', [VatValidationController::class, 'health'])->name('api.vat.health');
});

// add api route for country controller
Route::get('/vat/countries', [CountryController::class, 'index']);

Route::get('/countries', [CountryRatesController::class, 'index'])->name('api.countries.index');
Route::get('/countries/{slug}', [CountryRatesController::class, 'show'])->name('api.countries.show');

// LLM Context API
Route::get('/llm/vat-rates', function () {
    return Country::all()->map(function ($c) {
        return [
            'country' => $c->name,
            'iso' => $c->iso_code,
            'rates' => [
                'standard' => $c->standard_rate,
                'reduced' => $c->reduced_rate,
                'super_reduced' => $c->super_reduced_rate,
                'parking' => $c->parking_rate,
            ],
            'last_updated' => $c->updated_at->toIso8601String(),
        ];
    });
})->name('api.llm.vat-rates');

// VAT Rate Changes API
Route::get('/vat-changes', function () {
    return \App\Models\VatRateChange::with('country:id,name,code,slug')
        ->orderByDesc('change_date')
        ->limit(100)
        ->get()
        ->map(function ($change) {
            return [
                'id' => $change->id,
                'country' => [
                    'name' => $change->country->name ?? '',
                    'code' => $change->country->code ?? '',
                    'slug' => $change->country->slug ?? '',
                ],
                'rate_type' => $change->rate_type,
                'old_rate' => (float) $change->old_rate,
                'new_rate' => (float) $change->new_rate,
                'change_date' => $change->change_date?->toDateString(),
                'change_direction' => $change->change_direction,
                'change_reason' => $change->change_reason,
                'description' => $change->description,
            ];
        });
})->name('api.vat-changes');

// MCP Server (Model Context Protocol) — read-only, no auth
Route::post('/mcp', [McpController::class, 'handle'])->name('api.mcp');

// x402 Payment Protocol — info endpoint (free, describes paid routes)
Route::get('/x402/info', [X402Controller::class, 'info'])->name('api.x402.info');

// x402 Bazaar-compatible resource discovery
Route::get('/x402/discovery/resources', [X402Controller::class, 'discoveryResources'])->name('api.x402.discovery');

// x402 Payment Protocol — paid endpoints (require x402 payment when enabled)
Route::middleware(\App\Http\Middleware\X402PaymentMiddleware::class)->group(function () {
    Route::get('/x402/donate', [X402Controller::class, 'donate'])->name('api.x402.donate');
    Route::get('/x402/premium/vat-rates', [X402Controller::class, 'premiumVatRates'])->name('api.x402.premium.vat-rates');
    Route::get('/x402/premium/country/{slug}', [X402Controller::class, 'premiumCountry'])->name('api.x402.premium.country');
});
