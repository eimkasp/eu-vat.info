<?php

use App\Http\Controllers\EmbedController;
use App\Http\Controllers\LangController;
use App\Http\Controllers\LlmsController;
use App\Http\Controllers\RedirectController;
use App\Http\Controllers\SitemapController;
use App\Http\Controllers\WellKnownController;
use App\Livewire\CountryPage;
use App\Livewire\Home;
use App\Livewire\HtmlSitemap;
use App\Livewire\Tools;
use App\Livewire\VatCalculator;
use App\Livewire\ChromeExtension;
use App\Livewire\Donate;
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
    Route::get('/country/{slug}', [RedirectController::class, 'country'])->name('country.show');
    Route::get('/country/{slug}/{tab}', [RedirectController::class, 'country'])
        ->where('tab', 'vat-calculator|vat-validator|history|vat-guide|overview')
        ->name('country.tab');

    Route::get('/tools', Tools::class)->name('tools');

    Route::get('/vat-calculator', VatCalculator::class)->name('vat-calculator');
    Route::get('/vat-map', VatMap::class)->name('vat-map');
    Route::get('/vat-number-validator', ViesValidatorPage::class)->name('vies-validator');
    Route::get('/vat-number-validator/{slug}', ViesValidatorPage::class)->name('vies-validator.country');
    Route::get('/vat-validation-api', VatValidationApiDocs::class)->name('vat-validation-api');

    // 301 redirect: /vat-calculator/{iso_code} → /vat-calculator/{slug} (e.g., /vat-calculator/mt → /vat-calculator/malta)
    Route::get('/vat-calculator/{code}', [RedirectController::class, 'isoCode'])
        ->where('code', '[a-zA-Z]{2}');

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
    Route::get('/chrome-extension', ChromeExtension::class)->name('chrome-extension');
    Route::get('/donate', Donate::class)->name('donate');
    Route::get('/privacy', PrivacyPolicy::class)->name('privacy');
    Route::get('/sitemap', HtmlSitemap::class)->name('html-sitemap');
};

// Locale-prefixed routes for non-default languages (registered FIRST)
$supported = array_keys(config('translation.supported_languages', []));
$nonDefault = array_filter($supported, fn ($l) => $l !== config('translation.default_language', 'en'));
$localePattern = implode('|', $nonDefault);

Route::prefix('{locale}')
    ->where(['locale' => $localePattern])
    ->name('locale.')
    ->group($registerRoutes);

// Default locale (en) — no prefix (registered LAST so names point to root URIs)
$registerRoutes();

// Legacy redirect: /calculation?country=X&amount=Y&rate=Z&mode=M → /vat-calculation/X/Y/Z/M
Route::get('/calculation', [RedirectController::class, 'legacyCalculation']);

// Language switch route
Route::get('/lang/{locale}', [LangController::class, 'switch'])->name('lang.switch');

// Non-localised routes (sitemap, embed, API, etc.)
Route::get('/sitemap/generate', [SitemapController::class, 'index'])->name('sitemap.generate');
Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap');

// RFC 9727 — API Catalog
Route::get('/.well-known/api-catalog', [WellKnownController::class, 'apiCatalog'])->name('api-catalog');

// RFC 8414 — OAuth 2.0 Authorization Server Metadata
Route::get('/.well-known/oauth-authorization-server', [WellKnownController::class, 'oauthAuthorizationServer'])->name('oauth-discovery');

// RFC 7517 — JSON Web Key Set
Route::get('/.well-known/jwks.json', [WellKnownController::class, 'jwks'])->name('jwks');

// IETF WebBotAuth — HTTP Message Signatures Directory
Route::get('/.well-known/http-message-signatures-directory', [WellKnownController::class, 'httpMessageSignaturesDirectory'])->name('web-bot-auth');

// Agent Skills Discovery Index (RFC v0.2.0)
Route::get('/.well-known/agent-skills/index.json', [WellKnownController::class, 'agentSkillsIndex'])->name('agent-skills-index');
Route::redirect('/.well-known/agent-skills', '/.well-known/agent-skills/index.json', 301);

// Agent skill files (text/markdown) for AI agent discovery
Route::get('/.well-known/agent-skills/{skill}/SKILL.md', [WellKnownController::class, 'agentSkill'])
    ->where('skill', '[a-z0-9\-]+')
    ->name('agent-skill');

// RFC 9728 — OAuth Protected Resource Metadata
Route::get('/.well-known/oauth-protected-resource', [WellKnownController::class, 'oauthProtectedResource'])->name('oauth-protected-resource');

// SEP-1649 — MCP Server Card for agent discovery
Route::get('/.well-known/mcp/server-card.json', [WellKnownController::class, 'mcpServerCard'])->name('mcp-server-card');

Route::get('/embed/{country?}', [EmbedController::class, 'index'])->name('widget.embed');
Route::get('/public/embed/{country?}', [EmbedController::class, 'iframe'])->name('widget.iframe');
Route::get('/embed/preview/{country?}', [EmbedController::class, 'preview'])->name('widget.preview');

// LLM-optimised full VAT rates table
Route::get('/llms-full.txt', [LlmsController::class, 'fullTxt']);
