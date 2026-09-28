<?php

namespace App\Support\Vat;

use NumberFormatter;

/**
 * Parses human-typed amounts such as "1,234.56", "1.234,56", "1 234,5", "€100" or "12'500.10".
 *
 * Mirrors resources/js/vat.js so server-rendered and client-side results never disagree.
 * A single separator followed by exactly three digits is ambiguous, so the locale decides.
 */
final class AmountParser
{
    /** @var array<string, string> */
    private static array $decimalSeparators = [];

    public static function parse(mixed $input, string $locale = 'en'): ?float
    {
        if (is_int($input) || is_float($input)) {
            return is_finite((float) $input) ? (float) $input : null;
        }

        if (! is_string($input) && ! $input instanceof \Stringable) {
            return null;
        }

        $value = (string) preg_replace("/[\s\x{00A0}\x{202F}']/u", '', trim((string) $input));

        if ($value === '') {
            return null;
        }

        $negative = (bool) preg_match('/^-|-$/', $value);
        $value = (string) preg_replace('/[^\d.,]/', '', $value);

        if (! preg_match('/\d/', $value)) {
            return null;
        }

        $lastDot = strrpos($value, '.');
        $lastComma = strrpos($value, ',');

        if ($lastDot !== false && $lastComma !== false) {
            $decimal = $lastDot > $lastComma ? '.' : ',';
            $value = str_replace($decimal === '.' ? ',' : '.', '', $value);

            if (substr_count($value, $decimal) > 1) {
                return null;
            }

            $value = str_replace($decimal, '.', $value);
        } elseif ($lastDot !== false || $lastComma !== false) {
            $separator = $lastDot !== false ? '.' : ',';
            $fraction = substr($value, (int) strrpos($value, $separator) + 1);

            if (substr_count($value, $separator) > 1 || (strlen($fraction) === 3 && $separator !== self::decimalSeparator($locale))) {
                $value = str_replace($separator, '', $value);
            } else {
                $value = str_replace($separator, '.', $value);
            }
        }

        if (! preg_match('/^(\d+\.?\d*|\.\d+)$/', $value)) {
            return null;
        }

        return $negative ? -(float) $value : (float) $value;
    }

    private static function decimalSeparator(string $locale): string
    {
        return self::$decimalSeparators[$locale] ??= (string) ((new NumberFormatter($locale, NumberFormatter::DECIMAL))
            ->getSymbol(NumberFormatter::DECIMAL_SEPARATOR_SYMBOL) ?: '.');
    }
}
