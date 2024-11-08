<?php

use App\Http\Controllers\CountryController;
use App\Http\Controllers\Api\CountryRatesController;
use Illuminate\Support\Facades\Route;
// add api route for country controller
Route::get('/vat/countries', [CountryController::class, 'index']);

Route::get('/countries', [CountryRatesController::class, 'index'])->name('api.countries.index');
Route::get('/countries/{slug}', [CountryRatesController::class, 'show'])->name('api.countries.show');