<?php

namespace App\Services\Seo;

use App\Models\Country;
use Illuminate\Support\Collection;

class InternalLinkService
{
    public function relatedCountries(Country $country, int $limit = 6): Collection
    {
        return Country::query()
            ->where('is_eu_member', true)
            ->whereKeyNot($country->getKey())
            ->orderByRaw('ABS(standard_rate - ?)', [(float) $country->standard_rate])
            ->orderBy('name')
            ->limit($limit)
            ->get();
    }

    public function relatedCalculatorCountries(Country $country, int $limit = 6): Collection
    {
        return Country::calculatorAvailable()
            ->whereKeyNot($country->getKey())
            ->orderByRaw('ABS(standard_rate - ?)', [(float) $country->standard_rate])
            ->orderByDesc('is_eu_member')
            ->orderBy('name')
            ->limit($limit)
            ->get();
    }

    public function approvedPairsFor(Country $country): Collection
    {
        return collect(config('seo.comparisons', []))
            ->filter(fn (array $pair) => in_array($country->slug, $pair, true))
            ->values();
    }

    public function canonicalPair(string $left, string $right): ?array
    {
        foreach (config('seo.comparisons', []) as $pair) {
            if ($pair === [$left, $right]) {
                return $pair;
            }

            if ($pair === [$right, $left]) {
                return $pair;
            }
        }

        return null;
    }
}
