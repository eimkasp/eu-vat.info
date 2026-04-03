<?php

use App\Livewire\HeroCalculator;
use App\Models\Country;
use Livewire\Livewire;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

it('calculates Remove VAT (include mode) correctly', function () {
    Country::factory()
        ->withRates(23, 8)
        ->create([
            'name' => 'Poland',
            'slug' => 'poland',
            'iso_code' => 'PL',
        ]);

    // Remove VAT mode: 100 including 23% VAT
    // Net = 100 / 1.23 = 81.30
    // VAT = 100 - 81.30 = 18.70
    // Total = 100.00
    Livewire::test(HeroCalculator::class, ['initialCountry' => 'poland'])
        ->set('amount', 100)
        ->call('calculate', 'include', 23, false, null)
        ->assertSet('mode', 'include')
        ->assertSet('net_amount', 81.30)
        ->assertSet('vat_amount', 18.70)
        ->assertSet('total', 100.00);
});

it('calculates Add VAT (exclude mode) correctly', function () {
    Country::factory()
        ->withRates(23, 8)
        ->create([
            'name' => 'Poland',
            'slug' => 'poland',
            'iso_code' => 'PL',
        ]);

    // Add VAT mode: 100 net + 23% VAT
    // Net = 100
    // VAT = 23
    // Total = 123
    Livewire::test(HeroCalculator::class, ['initialCountry' => 'poland'])
        ->set('amount', 100)
        ->call('calculate', 'exclude', 23, false, null)
        ->assertSet('mode', 'exclude')
        ->assertSet('net_amount', 100.00)
        ->assertSet('vat_amount', 23.00)
        ->assertSet('total', 123.00);
});

it('setMode immediately recalculates with correct mode', function () {
    Country::factory()
        ->withRates(23, 8)
        ->create([
            'name' => 'Poland',
            'slug' => 'poland',
            'iso_code' => 'PL',
        ]);

    // Start in 'exclude' mode, then switch to 'include'
    Livewire::test(HeroCalculator::class, ['initialCountry' => 'poland'])
        ->set('amount', 100)
        ->call('setMode', 'include')
        ->assertSet('mode', 'include')
        ->assertSet('net_amount', 81.30)
        ->assertSet('vat_amount', 18.70)
        ->assertSet('total', 100.00);
});

it('selectRate immediately recalculates with correct rate', function () {
    Country::factory()
        ->withRates(23, 8)
        ->create([
            'name' => 'Poland',
            'slug' => 'poland',
            'iso_code' => 'PL',
        ]);

    // Switch from standard (23%) to reduced (8%) rate
    Livewire::test(HeroCalculator::class, ['initialCountry' => 'poland'])
        ->set('amount', 100)
        ->call('selectRate', 8)
        ->assertSet('selectedRate', 8)
        ->assertSet('vat_amount', 8.00)
        ->assertSet('total', 108.00);
});

it('calculate method accepts mode parameter and overrides default', function () {
    Country::factory()
        ->withRates(21, 9)
        ->create([
            'name' => 'Germany',
            'slug' => 'germany',
            'iso_code' => 'DE',
        ]);

    // Default mode is 'exclude', but passing 'include' should override
    Livewire::test(HeroCalculator::class, ['initialCountry' => 'germany'])
        ->set('amount', 121)
        ->call('calculate', 'include', 21, false, null)
        ->assertSet('mode', 'include')
        ->assertSet('net_amount', 100.00)
        ->assertSet('vat_amount', 21.00)
        ->assertSet('total', 121.00);
});
