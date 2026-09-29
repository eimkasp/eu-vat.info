<?php

namespace App\Support\Vat;

use NumberFormatter;

final class Money
{
    /** @var array<string, NumberFormatter> */
    private static array $formatters = [];

    public static function format(float|int|string|null $amount, ?string $currency = 'EUR', ?string $locale = null, int $decimals = 2): string
    {
        $locale ??= app()->getLocale();
        $currency = strtoupper((string) ($currency ?: 'EUR'));
        $formatter = self::$formatters["{$locale}|{$currency}|{$decimals}"] ??= self::makeFormatter($locale, $decimals);

        $formatted = $formatter->formatCurrency((float) $amount, $currency);

        return $formatted === false ? number_format((float) $amount, $decimals).' '.$currency : $formatted;
    }

    public static function percent(float|int|string|null $rate, ?string $locale = null): string
    {
        $formatter = new NumberFormatter($locale ?? app()->getLocale(), NumberFormatter::DECIMAL);
        $formatter->setAttribute(NumberFormatter::MAX_FRACTION_DIGITS, 2);

        return $formatter->format((float) $rate).'%';
    }

    private static function makeFormatter(string $locale, int $decimals): NumberFormatter
    {
        $formatter = new NumberFormatter($locale, NumberFormatter::CURRENCY);
        $formatter->setAttribute(NumberFormatter::MIN_FRACTION_DIGITS, $decimals);
        $formatter->setAttribute(NumberFormatter::MAX_FRACTION_DIGITS, $decimals);

        return $formatter;
    }
}
