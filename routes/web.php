<?php

use App\Livewire\Home;
use Illuminate\Support\Facades\Route;
use App\Livewire\Counter;
use App\Livewire\Country;

Route::get('/', Home::class);
Route::get('/country/{country}', Country::class)->name('country.show');
 
Route::get('/counter', Counter::class);
