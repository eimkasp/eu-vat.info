<?php

use App\Livewire\ViesValidatorPage;
use App\Models\Country;
use App\Models\VatRateRule;
use Livewire\Livewire;

it('shows maintained country-specific VAT number guidance with an official source', function () {
    Country::factory()->create([
        'name' => 'Germany',
        'slug' => 'germany',
        'iso_code' => 'DE',
        'is_eu_member' => true,
    ]);

    $this->get('/vat-number-validator/germany')
        ->assertOk()
        ->assertSee('DE + national identifier')
        ->assertSee('Only national tax administrations can issue VAT identification numbers')
        ->assertSee('taxation-customs.ec.europa.eu/taxation/vat/vat-directive/vat-identification-numbers_en');
});

it('uses the EL VAT prefix guidance for Greece', function () {
    Country::factory()->create([
        'name' => 'Greece',
        'slug' => 'greece',
        'iso_code' => 'GR',
        'is_eu_member' => true,
    ]);

    $this->get('/vat-number-validator/greece')
        ->assertOk()
        ->assertSee('EL + national identifier')
        ->assertSee('Greece uses EL for VAT identification numbers');
});

it('refreshes VAT format guidance after detecting a typed country prefix', function () {
    Livewire::test(ViesValidatorPage::class)
        ->set('vat_number', 'EL123456789')
        ->assertSet('country_code', 'GR')
        ->assertSet('vatFormat.prefix', 'EL');
});

it('publishes only sourced and verified category VAT rules', function () {
    $country = Country::factory()->create(['is_eu_member' => true]);

    $verified = VatRateRule::create([
        'country_id' => $country->id,
        'category_slug' => 'books',
        'category_name' => 'Books',
        'rate_type' => 'reduced',
        'rate' => 7,
        'source_url' => 'https://example.gov/books-vat',
        'verified_at' => now(),
        'published_at' => now()->subMinute(),
    ]);
    VatRateRule::create([
        'country_id' => $country->id,
        'category_slug' => 'food',
        'category_name' => 'Food',
        'rate_type' => 'reduced',
        'rate' => 7,
    ]);

    expect(VatRateRule::indexable()->pluck('id')->all())->toBe([$verified->id]);
});
