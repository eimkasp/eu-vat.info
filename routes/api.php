<?php

use App\Http\Controllers\CountryController;
use Illuminate\Support\Facades\Route;
// add api route for country controller
Route::get('/vat/countries', [CountryController::class, 'index']);