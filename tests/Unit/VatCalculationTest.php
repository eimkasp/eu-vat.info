<?php

use App\Support\Vat\Money;
use App\Support\Vat\VatCalculation;
use App\Support\Vat\VatMode;

it('adds VAT to a net amount', function (float $net, float $rate, float $vat, float $gross) {
    $calculation = VatCalculation::addVat($net, $rate);

    expect($calculation->net)->toBe($net)
        ->and($calculation->vat)->toBe($vat)
        ->and($calculation->gross)->toBe($gross)
        ->and($calculation->mode)->toBe(VatMode::Exclude)
        ->and($calculation->input())->toBe($net);
})->with([
    'standard rate' => [100, 20, 20.0, 120.0],
    'reduced rate' => [100, 9, 9.0, 109.0],
    'super-reduced rate' => [100, 5, 5.0, 105.0],
    'fractional rate' => [100, 2.1, 2.1, 102.1],
    'cents' => [50, 19, 9.5, 59.5],
    'large amount' => [100000, 21, 21000.0, 121000.0],
    'zero amount' => [0, 21, 0.0, 0.0],
    'zero rate' => [100, 0, 0.0, 100.0],
]);

it('extracts VAT from a gross amount', function (float $gross, float $rate, float $net, float $vat) {
    $calculation = VatCalculation::removeVat($gross, $rate);

    expect($calculation->gross)->toBe($gross)
        ->and($calculation->net)->toBe($net)
        ->and($calculation->vat)->toBe($vat)
        ->and($calculation->mode)->toBe(VatMode::Include)
        ->and($calculation->input())->toBe($gross);
})->with([
    'german standard rate' => [119, 19, 100.0, 19.0],
    'polish standard rate' => [100, 23, 81.3, 18.7],
    'rounded to cents' => [121, 21, 100.0, 21.0],
    'european format amount' => [1234.56, 20, 1028.8, 205.76],
]);

it('keeps net plus VAT equal to gross after rounding', function () {
    foreach ([0.01, 9.99, 17.5, 333.33, 1234.56, 99999.99] as $amount) {
        foreach ([5, 7, 17, 19, 21, 23, 25.5, 27] as $rate) {
            $calculation = VatCalculation::removeVat($amount, $rate);

            expect(round($calculation->net + $calculation->vat, 2))->toBe($calculation->gross);
        }
    }
});

it('clamps rates and amounts to supported bounds', function () {
    expect(VatCalculation::addVat(100, 150)->rate)->toBe(100.0)
        ->and(VatCalculation::addVat(100, -5)->rate)->toBe(0.0)
        ->and(VatCalculation::addVat(-50, 20)->net)->toBe(0.0)
        ->and(VatCalculation::addVat(1e15, 20)->net)->toBe((float) VatCalculation::MAX_AMOUNT);
});

it('maps loose mode input onto the two supported modes', function () {
    expect(VatMode::fromInput('include'))->toBe(VatMode::Include)
        ->and(VatMode::fromInput('REMOVE'))->toBe(VatMode::Include)
        ->and(VatMode::fromInput('exclude'))->toBe(VatMode::Exclude)
        ->and(VatMode::fromInput('anything else'))->toBe(VatMode::Exclude);
});

it('serialises a calculation for the API and history', function () {
    expect(VatCalculation::make('100', '19', 'exclude')->toArray())->toBe([
        'net' => 100.0,
        'vat' => 19.0,
        'gross' => 119.0,
        'rate' => 19.0,
        'mode' => 'exclude',
    ]);
});

it('formats money and percentages for the requested locale', function () {
    expect(Money::format(1234.5, 'EUR', 'en'))->toBe('€1,234.50')
        ->and(Money::format(1234.5, 'EUR', 'de'))->toBe("1.234,50\u{00A0}€")
        ->and(Money::format(100, 'EUR', 'en', 0))->toBe('€100')
        ->and(Money::percent(5.5, 'en'))->toBe('5.5%')
        ->and(Money::percent(5.5, 'de'))->toBe('5,5%');
});
