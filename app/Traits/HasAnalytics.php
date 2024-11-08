<?php

namespace App\Traits;

use App\Models\CountryAnalytic;
use Illuminate\Database\Eloquent\Relations\HasMany;

trait HasAnalytics
{
    public function analytics(): HasMany
    {
        return $this->hasMany(CountryAnalytic::class);
    }

    public function getViewsCount(): int
    {
        return $this->analytics()->where('type', 'view')->count();
    }

    public function getCalculatorUsageCount(): int
    {
        return $this->analytics()->where('type', 'calculator')->count();
    }
}
