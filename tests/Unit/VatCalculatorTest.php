<?php

use App\Livewire\VatCalculator;
use App\Models\Country;
use Livewire\Livewire;

// Test VAT calculation with valid input
it('calculates VAT correctly when VAT is included', function () {
    $country = Country::factory()
        ->withRates(21, 9)
        ->create([
            'name' => 'Test Country',
            'slug' => 'test-country',
        ]);

    Livewire::test(VatCalculator::class, ['slug' => 'test-country'])
        ->set('amount', '100')
        ->set('vat_included', 'include')
        ->set('selectedRate', 21)
        ->call('calculate')
        ->assertSet('total', 121.00)
        ->assertSet('vat_amount', 21.00)
        ->assertSet('error_message', null);
});

// Add more test cases
it('handles zero amount correctly', function () {
    $country = Country::factory()
        ->withRates(21, 9)
        ->create();

    Livewire::test(VatCalculator::class, ['slug' => $country->slug])
        ->set('amount', '0')
        ->set('vat_included', 'include')
        ->set('selectedRate', 21)
        ->call('calculate')
        ->assertSet('total', 0.00)
        ->assertSet('vat_amount', 0.00)
        ->assertSet('error_message', null);
});

it('handles large numbers correctly', function () {
    $country = Country::factory()
        ->withRates(21, 9)
        ->create();

    Livewire::test(VatCalculator::class, ['slug' => $country->slug])
        ->set('amount', '999999.99')
        ->set('vat_included', 'include')
        ->set('selectedRate', 21)
        ->call('calculate')
        ->assertSet('total', 1209999.99)
        ->assertSet('vat_amount', 210000.00)
        ->assertSet('error_message', null);
});

// Test input validation for invalid numbers
it('handles invalid numeric input gracefully', function () {
    $country = Country::factory()->create([
        'name' => 'Test Country',
        'slug' => 'test-country',
        'standard_rate' => 21,
    ]);

    Livewire::test(VatCalculator::class, ['slug' => 'test-country'])
        ->set('amount', 'invalid')
        ->call('calculate')
        ->assertSet('total', 0)
        ->assertSet('vat_amount', 0)
        ->assertSet('error_message', 'Invalid number format. Please enter a valid number.');
});

// Test comma to dot conversion in European number format
it('converts comma to dot in European number format', function () {
    $country = Country::factory()->create([
        'name' => 'Test Country',
        'slug' => 'test-country',
        'standard_rate' => 20,
    ]);

    Livewire::test(VatCalculator::class, ['slug' => 'test-country'])
        ->set('amount', '1.234,56')  // European format
        ->set('vat_included', 'include')
        ->set('selectedRate', 20)
        ->call('calculate')
        ->assertSet('amount', 1234.56)
        ->assertSet('total', 1481.47)  // 1234.56 + 20% VAT
        ->assertSet('error_message', null);
});
