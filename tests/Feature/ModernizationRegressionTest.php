<?php

use App\Models\Country;
use App\Models\VatRate;
use App\Models\VatRateChange;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

beforeEach(function () {
    Cache::flush();

    Country::factory()->create([
        'name' => 'Austria', 'slug' => 'austria', 'iso_code' => 'AT', 'standard_rate' => 20,
        'reduced_rate' => '10 / 13', 'parking_rate' => 13, 'currency_code' => 'EUR',
    ]);
    Country::factory()->create([
        'name' => 'Sweden', 'slug' => 'sweden', 'iso_code' => 'SE', 'standard_rate' => 25,
        'reduced_rate' => '12 / 6', 'currency_code' => 'SEK',
    ]);
});

it('emits valid schema.org JSON-LD on every redesigned page', function (string $path) {
    $html = $this->get($path)->assertOk()->getContent();

    preg_match_all('#<script type="application/ld\+json">(.*?)</script>#s', $html, $matches);

    expect($matches[1])->not->toBeEmpty();

    foreach ($matches[1] as $json) {
        expect(json_decode($json, true, flags: JSON_THROW_ON_ERROR))->toHaveKey('@context', 'https://schema.org');
    }
})->with(['/', '/vat-calculator/austria', '/vat-number-validator', '/vat-changes', '/tools', '/changelog', '/sitemap']);

it('serves the v1 API with every reduced rate and correct currency', function () {
    $this->getJson('/api/v1/countries/austria')
        ->assertOk()
        ->assertJsonPath('data.code', 'AT')
        ->assertJsonPath('data.rates.reduced', 10)
        ->assertJsonPath('data.rates.reduced_rates', [10, 13])
        ->assertJsonPath('data.rates.parking', 13);

    $this->getJson('/api/v1/calculate?amount=100&country=SE&rate_type=reduced&mode=remove')
        ->assertOk()
        ->assertJsonPath('data.rate', 6)
        ->assertJsonPath('data.net', 94.34)
        ->assertJsonPath('data.vat', 5.66)
        ->assertJsonPath('data.currency', 'SEK');
});

it('only redirects the language switch to paths on this site', function () {
    $this->withHeader('referer', 'https://evil.example/phish')
        ->get('/lang/de')
        ->assertRedirect('/de');

    $this->withHeader('referer', url('/vat-calculator/austria'))
        ->get('/lang/fr')
        ->assertRedirect('/fr/vat-calculator/austria');

    $this->withHeader('referer', url('/de/vat-map'))
        ->get('/lang/en')
        ->assertRedirect('/vat-map');

    $this->get('/lang/xx')->assertNotFound();
});

it('restores averaged reduced rates and moves Bulgaria to the euro', function () {
    DB::table('countries')->where('iso_code', 'AT')->update(['reduced_rate' => '11.5']);
    Country::factory()->create(['name' => 'Bulgaria', 'slug' => 'bulgaria', 'iso_code' => 'BG', 'currency_code' => 'BGN', 'currency_symbol' => 'лв']);
    Country::factory()->create(['name' => 'Belgium', 'slug' => 'belgium', 'iso_code' => 'BE', 'reduced_rate' => '7']);

    (require database_path('migrations/2026_09_28_000000_correct_reduced_rates_and_bulgarian_currency.php'))->up();

    expect(Country::query()->where('iso_code', 'AT')->value('reduced_rate'))->toBe('10 / 13')
        ->and(Country::query()->where('iso_code', 'BE')->value('reduced_rate'))->toBe('7')
        ->and(Country::query()->where('iso_code', 'BG')->value('currency_code'))->toBe('EUR');
});

it('removes duplicate historical rate rows without losing change records', function () {
    $austria = Country::query()->where('iso_code', 'AT')->firstOrFail();
    $attributes = ['country_id' => $austria->id, 'type' => 'standard', 'rate' => 20, 'effective_from' => '1984-01-01'];
    $keep = VatRate::query()->create($attributes);
    $duplicate = VatRate::query()->create($attributes);
    $change = VatRateChange::query()->create([
        'country_id' => $austria->id, 'vat_rate_id' => $duplicate->id, 'rate_type' => 'standard',
        'old_rate' => 18, 'new_rate' => 20, 'change_date' => '1984-01-01', 'change_direction' => 'increase',
    ]);

    (require database_path('migrations/2026_09_28_000100_remove_duplicate_vat_rate_rows.php'))->up();

    expect(VatRate::query()->where('country_id', $austria->id)->count())->toBe(1)
        ->and($change->fresh()->vat_rate_id)->toBe($keep->id);
});

it('computes shared calculations in both directions with the country currency', function () {
    $this->get('/vat-calculation/sweden/1000/25/include')
        ->assertOk()
        ->assertSee("SEK\u{00A0}800.00")
        ->assertSee("SEK\u{00A0}200.00")
        ->assertSee('noindex, follow', false);

    $this->get('/vat-calculation/sweden/100/150/exclude')->assertNotFound();
    $this->get('/vat-calculation/atlantis/100/20/exclude')->assertNotFound();
});

it('serves the embed builder and a resilient iframe widget', function () {
    Country::factory()->create(['name' => 'United Kingdom', 'slug' => 'united-kingdom', 'iso_code' => 'GB', 'standard_rate' => 20, 'is_eu_member' => false, 'vies_available' => false]);
    config()->set('calculator.additional_country_slugs', ['united-kingdom']);

    $this->get('/embed/sweden')->assertOk()->assertSee('Embed a free VAT calculator for Sweden');
    $this->get('/embed/atlantis')->assertNotFound();

    $this->get('/public/embed/atlantis?style=horizontal')
        ->assertOk()
        ->assertSee('data-calculator-surface="embed"', false)
        ->assertHeaderMissing('X-Frame-Options');

    expect($this->get('/embed/sweden')->headers->get('Content-Security-Policy'))->toContain("frame-src 'self'");
});

it('lazy-loads localised command palette entries', function () {
    $this->getJson('/search-index.json?locale=de')
        ->assertOk()
        ->assertJsonFragment(['url' => '/de/vat-calculator/austria'])
        ->assertHeader('Cache-Control', 'max-age=600, public');

    $this->get('/')->assertDontSee('/de/vat-calculator/austria', false);
});

it('keeps third-party flag hosts out of pages and the CSP', function () {
    $response = $this->get('/vat-calculator/austria');

    expect($response->getContent())->not->toContain('flagcdn.com')
        ->and($response->headers->get('Content-Security-Policy'))->not->toContain('flagcdn.com');
});
