<?php

use App\Http\Controllers\CountryController;
use App\Http\Controllers\Api\CountryRatesController;
use App\Http\Controllers\Api\VatValidationController;
use Illuminate\Support\Facades\Route;
use App\Models\Country;

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
