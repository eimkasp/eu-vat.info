<?php

use App\Http\Controllers\Api\CountryRatesController;
use App\Http\Controllers\Api\McpController;
use App\Http\Controllers\Api\VatValidationController;
use App\Http\Controllers\CountryController;
use App\Models\Country;
use Illuminate\Support\Facades\Route;

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
