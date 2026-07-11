<?php

namespace App\Services\Seo;

use App\Models\VatRateRule;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class VatCategorySeoService
{
    public function minimumCountryCoverage(): int
    {
        return max(2, (int) config('seo.category_minimum_country_coverage', 3));
    }

    public function currentRules(): Collection
    {
        return $this->currentRulesQuery()
            ->with('country')
            ->orderByDesc('effective_from')
            ->orderByDesc('verified_at')
            ->get()
            ->unique(fn (VatRateRule $rule) => $rule->country_id.':'.$rule->category_slug)
            ->values();
    }

    public function eligibleCategories(): Collection
    {
        return $this->currentRulesQuery()
            ->select('category_slug')
            ->selectRaw('MIN(category_name) as category_name')
            ->selectRaw('COUNT(DISTINCT country_id) as country_count')
            ->selectRaw('MIN(rate) as minimum_rate')
            ->selectRaw('MAX(rate) as maximum_rate')
            ->selectRaw('MAX(verified_at) as last_verified_at')
            ->groupBy('category_slug')
            ->havingRaw('COUNT(DISTINCT country_id) >= ?', [$this->minimumCountryCoverage()])
            ->orderBy('category_name')
            ->get()
            ->map(fn (VatRateRule $rule) => [
                'slug' => $rule->category_slug,
                'name' => (string) $rule->category_name,
                'country_count' => (int) $rule->country_count,
                'minimum_rate' => (float) $rule->minimum_rate,
                'maximum_rate' => (float) $rule->maximum_rate,
                'last_verified_at' => $rule->last_verified_at,
            ])
            ->values();
    }

    public function rulesForCategory(string $category): Collection
    {
        return $this->currentRulesQuery()
            ->where('category_slug', $category)
            ->with('country')
            ->orderByDesc('effective_from')
            ->orderByDesc('verified_at')
            ->get()
            ->unique('country_id')
            ->sortBy(fn (VatRateRule $rule) => $rule->country->name)
            ->values();
    }

    public function ruleForCountry(string $country, string $category): ?VatRateRule
    {
        return $this->currentRulesQuery()
            ->where('category_slug', $category)
            ->whereHas('country', fn (Builder $query) => $query->where('slug', $country))
            ->with('country')
            ->orderByDesc('effective_from')
            ->orderByDesc('verified_at')
            ->first();
    }

    public function rulesForCountry(string $country): Collection
    {
        return $this->currentRulesQuery()
            ->whereHas('country', fn (Builder $query) => $query->where('slug', $country))
            ->with('country')
            ->orderByDesc('effective_from')
            ->orderByDesc('verified_at')
            ->get()
            ->unique('category_slug')
            ->values();
    }

    public function categoryIsEligible(string $category): bool
    {
        return $this->currentRulesQuery()
            ->where('category_slug', $category)
            ->distinct()
            ->count('country_id') >= $this->minimumCountryCoverage();
    }

    protected function currentRulesQuery(): Builder
    {
        return VatRateRule::query()
            ->indexable()
            ->current();
    }
}
