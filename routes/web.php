<?php

use App\Http\Controllers\EmbedController;
use App\Http\Controllers\SitemapController;
use App\Livewire\CountryPage;
use App\Livewire\Home;
use App\Livewire\HtmlSitemap;
use App\Livewire\Tools;
use App\Livewire\VatCalculator;
use App\Livewire\McpServer;
use App\Livewire\SharedCalculation;
use App\Livewire\PrivacyPolicy;
use App\Livewire\VatMap;
use App\Livewire\VatValidationApiDocs;
use App\Livewire\ViesValidatorPage;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Localised Routes
|--------------------------------------------------------------------------
| English (default): /vat-calculator, /country/germany, etc.
| Other languages:   /de/vat-calculator, /de/country/germany, etc.
*/

// Helper: register all app routes (used for both root and locale-prefix groups)
$registerRoutes = function () {
    Route::get('/', Home::class)->name('home');

    // 301 redirects: /country/{slug}[/{tab}] → /vat-calculator/{slug} (locale-aware)
    Route::get('/country/{slug}', function () {
        $slug = request()->route('slug');
        return redirect(locale_path('/vat-calculator/'.$slug), 301);
    })->name('country.show');
    Route::get('/country/{slug}/{tab}', function () {
        $slug = request()->route('slug');
        return redirect(locale_path('/vat-calculator/'.$slug), 301);
    })->where('tab', 'vat-calculator|vat-validator|history|vat-guide|overview')->name('country.tab');

    Route::get('/tools', Tools::class)->name('tools');

    Route::get('/vat-calculator', VatCalculator::class)->name('vat-calculator');
    Route::get('/vat-map', VatMap::class)->name('vat-map');
    Route::get('/vat-number-validator', ViesValidatorPage::class)->name('vies-validator');
    Route::get('/vat-number-validator/{slug}', ViesValidatorPage::class)->name('vies-validator.country');
    Route::get('/vat-validation-api', VatValidationApiDocs::class)->name('vat-validation-api');

    // 301 redirect: /vat-calculator/{iso_code} → /vat-calculator/{slug} (e.g., /vat-calculator/mt → /vat-calculator/malta)
    // Match 2-letter ISO codes that exist as country ISO codes but not as slugs
    Route::get('/vat-calculator/{code}', function () {
        $code = request()->route('code');
        $country = \App\Models\Country::where('iso_code', strtoupper($code))
            ->orWhere('iso_code_2', strtoupper($code))
            ->first();

        if ($country) {
            return redirect(locale_path('/vat-calculator/'.$country->slug), 301);
        }

        abort(404);
    })->where('code', '[a-zA-Z]{2}');

    Route::get('/vat-calculator/{slug}', VatCalculator::class)->name('vat-calculator.country');
    Route::get('/vat-calculation/{country}/{amount}/{rate}/{mode}', SharedCalculation::class)
        ->where(['amount' => '[0-9]+(\.[0-9]{1,2})?', 'rate' => '[0-9]+(\.[0-9]{1,2})?', 'mode' => 'exclude|include'])
        ->name('shared-calculation');
    Route::get('/top-vat-calculations', \App\Livewire\TopCalculations::class)->name('top-calculations');
    Route::get('/top-vat-calculations/{amount}', \App\Livewire\TopCalculationsAmount::class)
        ->where('amount', '100|200|500|1000|2500|5000|10000')
        ->name('top-calculations.amount');
    Route::get('/vat-changes', \App\Livewire\VatChangesHistory::class)->name('vat-changes');
    Route::get('/mcp-server', McpServer::class)->name('mcp-server');
    Route::get('/privacy', PrivacyPolicy::class)->name('privacy');
    Route::get('/sitemap', HtmlSitemap::class)->name('html-sitemap');
};

// Locale-prefixed routes for non-default languages (registered FIRST)
$supported = array_keys(config('translation.supported_languages', []));
$nonDefault = array_filter($supported, fn ($l) => $l !== config('translation.default_language', 'en'));
$localePattern = implode('|', $nonDefault);

Route::prefix('{locale}')
    ->where(['locale' => $localePattern])
    ->group($registerRoutes);

// Default locale (en) — no prefix (registered LAST so names point to root URIs)
$registerRoutes();

// Legacy redirect: /calculation?country=X&amount=Y&rate=Z&mode=M → /vat-calculation/X/Y/Z/M
Route::get('/calculation', function (\Illuminate\Http\Request $request) {
    $country = $request->query('country', '');
    $amount = $request->query('amount', '100');
    $rate = $request->query('rate', '0');
    $mode = $request->query('mode', 'exclude');

    if (!$country) {
        abort(404);
    }

    return redirect(locale_path("/vat-calculation/{$country}/{$amount}/{$rate}/{$mode}"), 301);
});

// Language switch route
Route::get('/lang/{locale}', function (string $locale) {
    $supported = array_keys(config('translation.supported_languages', []));
    if (! in_array($locale, $supported)) {
        abort(404);
    }
    session()->put('locale', $locale);

    // Redirect to the same page in the new locale
    $previous = url()->previous();
    $default = config('translation.default_language', 'en');
    $parsed = parse_url($previous);
    $path = $parsed['path'] ?? '/';

    // Strip existing locale prefix from path
    $path = preg_replace('#^/('.implode('|', $supported).')(/|$)#', '/', $path);
    $path = $path === '' ? '/' : $path;

    if ($locale === $default) {
        return redirect($path);
    }

    return redirect('/'.$locale.($path === '/' ? '' : $path));
})->name('lang.switch');

// Non-localised routes (sitemap, embed, API, etc.)
Route::get('/sitemap/generate', [SitemapController::class, 'index'])->name('sitemap.generate');
Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap');

Route::get('/embed/{country?}', [EmbedController::class, 'index'])->name('widget.embed');
Route::get('/public/embed/{country?}', [EmbedController::class, 'iframe'])->name('widget.iframe');
Route::get('/embed/preview/{country?}', [EmbedController::class, 'preview'])->name('widget.preview');

// LLM Documentation Full List
Route::get('/llms-full.txt', function () {
    $content = \Illuminate\Support\Facades\Cache::remember('llms_full_txt', 86400, function () {
        $countries = \App\Models\Country::orderBy('name')->get();
        $text = "# Full EU VAT Rates List\n\n";
        $text .= "| Country | ISO | Standard | Reduced | Super Reduced | Parking |\n";
        $text .= "|---|---|---|---|---|---|\n";
        foreach ($countries as $c) {
            $text .= "| {$c->name} | {$c->iso_code} | {$c->standard_rate}% | ".($c->reduced_rate ? "{$c->reduced_rate}%" : '-').' | '.($c->super_reduced_rate ? "{$c->super_reduced_rate}%" : '-').' | '.($c->parking_rate ? "{$c->parking_rate}%" : '-')." |\n";
        }

        return $text;
    });

    return response($content)->header('Content-Type', 'text/plain');
});
