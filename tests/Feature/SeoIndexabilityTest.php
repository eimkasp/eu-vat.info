<?php

use App\Models\Country;

it('redirects the legacy SEO host to the canonical host', function () {
    $response = $this->get('https://eu-vat.info/vat-calculator/germany?amount=100');

    $response->assertRedirect('https://vat.businesspress.io/vat-calculator/germany?amount=100');
    expect($response->getStatusCode())->toBe(301);
});

it('indexes only explicitly ready locales and limits hreflang to them', function () {
    $english = $this->get('/');
    $german = $this->get('/de');

    $english
        ->assertOk()
        ->assertSee('<meta name="robots" content="index, follow">', false)
        ->assertSee('hreflang="en"', false)
        ->assertDontSee('hreflang="de"', false);

    $german
        ->assertOk()
        ->assertSee('<meta name="robots" content="noindex, follow">', false)
        ->assertSee('<link rel="canonical" href="https://vat.businesspress.io/de">', false)
        ->assertDontSee('hreflang="de"', false);
});

it('keeps shared calculations usable but out of the search index', function () {
    Country::factory()->create([
        'name' => 'Germany',
        'slug' => 'germany',
        'iso_code' => 'DE',
        'standard_rate' => 19,
        'is_eu_member' => true,
    ]);

    $response = $this->get('/vat-calculation/germany/100/19/exclude');

    $response
        ->assertOk()
        ->assertSee('<meta name="robots" content="noindex, follow">', false)
        ->assertSee('<link rel="canonical" href="https://vat.businesspress.io/vat-calculator/germany">', false)
        ->assertDontSee('hreflang=', false);
});
