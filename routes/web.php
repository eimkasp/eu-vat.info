<?php

use App\Livewire\Home;
use Illuminate\Support\Facades\Route;
use App\Livewire\Counter;

Route::get('/', Home::class);
 
Route::get('/counter', Counter::class);
