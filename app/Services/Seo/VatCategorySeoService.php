<?php

namespace App\Services\Seo;

use App\Models\VatRateRule;
use Illuminate\Support\Collection;

class VatCategorySeoService
{
    public function minimumCountryCoverage(): int
    {
        return max(2, (int) config('seo.category_minimum_country_coverage', 3));
    }

    public function currentRules(): Collection
    {
        return VatRateRule::query()
            ->indexable()
            ->current()
            ->with('country')
            ->orderByDesc('effective_from')
            ->orderByDesc('verified_at')
            ->get()
            ->unique(fn (VatRateRule $rule) => $rule->country_id.':'.$rule->category_slug)
            ->values();
    }

    public function eligibleCategories(): Collection
    {
        return $this->currentRules()
            ->groupBy('category_slug')
            ->filter(fn (Collection $rules) => $rules->pluck('country_id')->unique()->count() >= $this->minimumCountryCoverage())
            ->map(function (Collection $rules, string $slug) {
                $rates = $rules->pluck('rate')->map(fn ($rate) => (float) $rate);

                return [
                    'slug' => $slug,
                    'name' => (string) $rules->first()->category_name,
                    'country_count' => $rules->pluck('country_id')->unique()->count(),
                    'minimum_rate' => $rates->min(),
                    'maximum_rate' => $rates->max(),
                    'last_verified_at' => $rules->max('verified_at'),
                ];
            })
            ->sortBy('name')
            ->values();
    }

    public function rulesForCategory(string $category): Collection
    {
        return $this->currentRules()
            ->where('category_slug', $category)
            ->sortBy(fn (VatRateRule $rule) => $rule->country->name)
            ->values();
    }

    public function ruleForCountry(string $country, string $category): ?VatRateRule
    {
        return $this->currentRules()
            ->first(fn (VatRateRule $rule) => $rule->country->slug === $country && $rule->category_slug === $category);
    }

    public function categoryIsEligible(string $category): bool
    {
        return $this->eligibleCategories()->contains('slug', $category);
    }
}
