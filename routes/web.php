<?php

use App\Http\Controllers\EmbedController;
use App\Http\Controllers\SitemapController;
use App\Livewire\Home;
use App\Livewire\Tools;
use App\Livewire\VatCalculator;
use App\Livewire\VatMap;
use Illuminate\Support\Facades\Route;
use App\Livewire\Counter;
use App\Livewire\CountryPage;
use App\Livewire\HtmlSitemap;
use League\CommonMark\Extension\Embed\Embed;

Route::get('/', Home::class)->name('home');
Route::get('/country/{slug}', CountryPage::class)->name('country.show');
Route::get('/country/{slug}/{tab}', CountryPage::class)->name('country.tab')
    ->where('tab', 'vat-calculator|vat-validator|history|vat-guide');

Route::get('/counter', Counter::class);
Route::get('/tools', Tools::class);

Route::get('/vat-calculator', VatCalculator::class)->name('vat-calculator');
Route::get('/vat-map', VatMap::class)->name('vat-map');
Route::get('/vat-calculator/{slug}', VatCalculator::class)->name('vat-calculator.country');
// Route::get('/vat-check/{slug?}', \App\Livewire\VatValidator::class)->name('vat-check');
// Route::get('/vat-navigator', \App\Livewire\VatNavigator::class)->name('vat-navigator');
Route::get('/vat-changes', \App\Livewire\VatChangesHistory::class)->name('vat-changes');
Route::get('/sitemap', HtmlSitemap::class)->name('html-sitemap');
Route::get('/sitemap/generate', [SitemapController::class, 'index'])->name('sitemap.generate');
Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap');

Route::get('/embed/{country?}', [EmbedController::class, 'index'])->name('widget.embed');
Route::get('/public/embed/{country?}', [EmbedController::class, 'iframe'])->name('widget.iframe');
Route::get('/embed/preview/{country?}', [EmbedController::class, 'preview'])->name('widget.preview');

// LLM Documentation Full List
Route::get('/llms-full.txt', function () {
    $countries = \App\Models\Country::orderBy('name')->get();
    $content = "# Full EU VAT Rates List\n\n";
    $content .= "| Country | ISO | Standard | Reduced | Super Reduced | Parking |\n";
    $content .= "|---|---|---|---|---|---|\n";
    foreach ($countries as $c) {
        $content .= "| {$c->name} | {$c->iso_code} | {$c->standard_rate}% | " . ($c->reduced_rate ? "{$c->reduced_rate}%" : "-") . " | " . ($c->super_reduced_rate ? "{$c->super_reduced_rate}%" : "-") . " | " . ($c->parking_rate ? "{$c->parking_rate}%" : "-") . " |\n";
    }
    return response($content)->header('Content-Type', 'text/plain');
});
