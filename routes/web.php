<?php

use App\Livewire\Home;
use App\Livewire\VatCalculator;
use Illuminate\Support\Facades\Route;
use App\Livewire\Counter;
use App\Livewire\Country;

Route::get('/', Home::class);
Route::get('/country/{slug}', Country::class)->name('country.show');
Route::get('/country/{slug}/history', Country::class)->name('country.vat.history');
 
Route::get('/counter', Counter::class);
Route::get('/vat-calculator', VatCalculator::class);
