<?php

namespace App\Support\Seo;

use App\Livewire\TopCalculations;

/**
 * Shared calculation URLs are open-ended, so only the ones the top calculations pages link to are indexable:
 * a top amount at a member state's standard rate, in either direction. Every other value stays out of the index.
 */
final class CalculationIndexing
{
    public static function isTopCalculation(string $country, float $amount, float $rate): bool
    {
        $match = collect(TopCalculations::euCountries())->firstWhere('slug', $country);

        return $match !== null
            && $match['standard_rate'] > 0
            && abs($match['standard_rate'] - $rate) < 0.001
            && in_array($amount, array_map('floatval', TopCalculations::AMOUNTS), true);
    }
}
