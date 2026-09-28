<?php

use App\Support\Vat\AmountParser;

it('parses plain and grouped amounts', function (string $input, string $locale, float $expected) {
    expect(AmountParser::parse($input, $locale))->toBe($expected);
})->with([
    'integer' => ['100', 'en', 100.0],
    'decimal point' => ['99.99', 'en', 99.99],
    'decimal comma' => ['99,99', 'de', 99.99],
    'english grouping' => ['1,234.56', 'en', 1234.56],
    'german grouping' => ['1.234,56', 'de', 1234.56],
    'german grouping read in english' => ['1.234,56', 'en', 1234.56],
    'space grouping' => ['1 234,5', 'fr', 1234.5],
    'no-break space grouping' => ["12\u{202F}500,10", 'fr', 12500.10],
    'swiss apostrophe grouping' => ["12'500.10", 'en', 12500.10],
    'currency symbol' => ['€ 100', 'en', 100.0],
    'leading dot' => ['.5', 'en', 0.5],
    'many thousands' => ['1,000,000', 'en', 1000000.0],
]);

it('lets the locale resolve a single separator followed by three digits', function () {
    expect(AmountParser::parse('1,234', 'en'))->toBe(1234.0)
        ->and(AmountParser::parse('1,234', 'de'))->toBe(1.234)
        ->and(AmountParser::parse('1.234', 'de'))->toBe(1234.0)
        ->and(AmountParser::parse('1.234', 'en'))->toBe(1.234);
});

it('keeps the sign of negative amounts so callers can reject them', function () {
    expect(AmountParser::parse('-100', 'en'))->toBe(-100.0);
});

it('rejects input that is not a number', function (mixed $input) {
    expect(AmountParser::parse($input, 'en'))->toBeNull();
})->with([
    'empty' => [''],
    'whitespace' => ['   '],
    'letters' => ['invalid'],
    'two decimal separators' => ['1.2.3,4,5'],
    'null' => [null],
    'array' => [['100']],
]);

it('accepts numeric scalars unchanged', function () {
    expect(AmountParser::parse(42, 'en'))->toBe(42.0)
        ->and(AmountParser::parse(19.5, 'en'))->toBe(19.5)
        ->and(AmountParser::parse(INF, 'en'))->toBeNull();
});
