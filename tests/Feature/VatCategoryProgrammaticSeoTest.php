<?php

use App\Models\Country;
use App\Models\VatRateRule;
use App\Services\Seo\VatCategorySeoService;

function categoryCountry(string $name, string $slug, string $iso, bool $eu = true): Country
{
    return Country::factory()->create([
        'name' => $name,
        'slug' => $slug,
        'iso_code' => $iso,
        'is_eu_member' => $eu,
    ]);
}

function categoryRule(Country $country, array $overrides = []): VatRateRule
{
    return VatRateRule::create(array_merge([
        'country_id' => $country->id,
        'category_slug' => 'books',
        'category_name' => 'Books',
        'rate_type' => 'reduced',
        'rate' => 7,
        'effective_from' => now()->subYear()->toDateString(),
        'effective_to' => null,
        'legal_basis' => 'National VAT Act, books provision',
        'source_url' => 'https://example.gov/books-vat',
        'verified_at' => now()->subDay(),
        'published_at' => now()->subDay(),
    ], $overrides));
}

it('limits current category rules to their effective date range', function () {
    $country = categoryCountry('Germany', 'germany', 'DE');
    $current = categoryRule($country);
    categoryRule($country, [
        'category_slug' => 'future-books',
        'effective_from' => now()->addMonth()->toDateString(),
    ]);
    categoryRule($country, [
        'category_slug' => 'expired-books',
        'effective_to' => now()->subMonth()->toDateString(),
    ]);

    expect(VatRateRule::current()->pluck('id')->all())->toBe([$current->id]);
});

it('qualifies category hubs only after verified EU country coverage reaches the threshold', function () {
    config()->set('seo.category_minimum_country_coverage', 3);

    foreach ([
        ['Germany', 'germany', 'DE'],
        ['France', 'france', 'FR'],
        ['Spain', 'spain', 'ES'],
    ] as [$name, $slug, $iso]) {
        categoryRule(categoryCountry($name, $slug, $iso));
    }

    categoryRule(categoryCountry('Switzerland', 'switzerland', 'CH', false));
    categoryRule(categoryCountry('Italy', 'italy', 'IT'), [
        'category_slug' => 'food',
        'category_name' => 'Food',
        'source_url' => null,
    ]);

    $categories = app(VatCategorySeoService::class)->eligibleCategories();

    expect($categories)->toHaveCount(1)
        ->and($categories->first()['slug'])->toBe('books')
        ->and($categories->first()['country_count'])->toBe(3);
});

it('publishes a category directory and source-backed comparison hub after the coverage threshold', function () {
    config()->set('seo.category_minimum_country_coverage', 3);

    foreach ([
        ['Germany', 'germany', 'DE', 7],
        ['France', 'france', 'FR', 5.5],
        ['Spain', 'spain', 'ES', 4],
    ] as [$name, $slug, $iso, $rate]) {
        categoryRule(categoryCountry($name, $slug, $iso), [
            'rate' => $rate,
            'source_url' => "https://example.gov/{$slug}/books-vat",
        ]);
    }

    $this->get('/vat-rates/categories')
        ->assertOk()
        ->assertSee('<link rel="canonical" href="https://eu-vat.info/vat-rates/categories">', false)
        ->assertSee('/vat-rates/categories/books')
        ->assertSee('3 EU countries');

    $this->get('/vat-rates/categories/books')
        ->assertOk()
        ->assertSee('<link rel="canonical" href="https://eu-vat.info/vat-rates/categories/books">', false)
        ->assertSee('Books VAT rates across the EU')
        ->assertSee('Germany')
        ->assertSee('7.00%')
        ->assertSee('https://example.gov/germany/books-vat')
        ->assertSee('"@type":"CollectionPage"', false)
        ->assertSee('"@type":"ItemList"', false);
});

it('does not publish category directories or hubs below the coverage threshold', function () {
    config()->set('seo.category_minimum_country_coverage', 3);

    categoryRule(categoryCountry('Germany', 'germany', 'DE'));
    categoryRule(categoryCountry('France', 'france', 'FR'));

    $this->get('/vat-rates/categories')->assertNotFound();
    $this->get('/vat-rates/categories/books')->assertNotFound();
});

it('publishes a sourced country-category detail page even before hub coverage is reached', function () {
    $country = categoryCountry('Germany', 'germany', 'DE');
    categoryRule($country, [
        'rate' => 7,
        'verified_at' => now()->subDay()->startOfDay(),
    ]);

    $this->get('/vat-rates/germany/categories/books')
        ->assertOk()
        ->assertSee('<link rel="canonical" href="https://eu-vat.info/vat-rates/germany/categories/books">', false)
        ->assertSee('Books VAT rate in Germany')
        ->assertSee('7.00%')
        ->assertSee('National VAT Act, books provision')
        ->assertSee('https://example.gov/books-vat')
        ->assertSee(now()->subDay()->startOfDay()->format('F j, Y'))
        ->assertSee('transaction-specific tax advice')
        ->assertSee('"@type":"WebPage"', false)
        ->assertSee('"@type":"DefinedTerm"', false)
        ->assertSee('/vat-calculator/germany');
});

it('returns not found for a country-category rule that is not publishable', function () {
    $country = categoryCountry('Germany', 'germany', 'DE');
    categoryRule($country, ['verified_at' => null]);

    $this->get('/vat-rates/germany/categories/books')->assertNotFound();
});

it('discovers only eligible category URLs and links them from country tools', function () {
    config()->set('seo.category_minimum_country_coverage', 3);

    foreach ([
        ['Germany', 'germany', 'DE'],
        ['France', 'france', 'FR'],
        ['Spain', 'spain', 'ES'],
    ] as [$name, $slug, $iso]) {
        categoryRule(categoryCountry($name, $slug, $iso));
    }

    categoryRule(categoryCountry('Italy', 'italy', 'IT'), [
        'category_slug' => 'food',
        'category_name' => 'Food',
        'published_at' => null,
    ]);

    $this->get('/sitemap.xml')
        ->assertOk()
        ->assertSee('/sitemaps/categories.xml');

    $this->get('/sitemaps/categories.xml')
        ->assertOk()
        ->assertSee('https://eu-vat.info/vat-rates/categories')
        ->assertSee('https://eu-vat.info/vat-rates/categories/books')
        ->assertSee('https://eu-vat.info/vat-rates/germany/categories/books')
        ->assertDontSee('/categories/food');

    $this->get('/llms.txt')
        ->assertOk()
        ->assertSee('VAT categories')
        ->assertSee('https://eu-vat.info/vat-rates/categories/books');

    $this->get('/vat-calculator/germany')
        ->assertOk()
        ->assertSee('/vat-rates/germany/categories/books')
        ->assertSee('Books VAT rate');
});
