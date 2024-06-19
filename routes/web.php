<?php

use App\Http\Controllers\EmbedController;
use App\Http\Controllers\SitemapController;
use App\Livewire\Home;
use App\Livewire\Tools;
use App\Livewire\VatCalculator;
use Illuminate\Support\Facades\Route;
use App\Livewire\Counter;
use App\Livewire\Country;
use League\CommonMark\Extension\Embed\Embed;

Route::get('/', Home::class);
Route::get('/country/{slug}', Country::class)->name('country.show');
Route::get('/country/{slug}/history', Country::class)->name('country.vat.history');
Route::get('/country/{slug}/vat-guide', Country::class)->name('country.vat.guide');
Route::get('/country/{slug}/vat-guide', Country::class)->name('country.vat.guide');
 
Route::get('/counter', Counter::class);
Route::get('/tools', Tools::class);

Route::get('/vat-calculator', VatCalculator::class)->name('vat-calculator');
Route::get('/vat-calculator/{slug}', VatCalculator::class)->name('vat-calculator.country');
Route::get('/sitemap/generate', [SitemapController::class, 'index'])->name('sitemap.generate');

Route::get('/embed/{country?}', [EmbedController::class, 'index'])->name('widget.embed');
Route::get('/public/embed/{country?}', [EmbedController::class, 'iframe'])->name('widget.iframe');
Route::get('/embed/preview/{country?}', [EmbedController::class, 'preview'])->name('widget.preview');