<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class VatRateRule extends Model
{
    protected $fillable = [
        'country_id',
        'category_slug',
        'category_name',
        'rate_type',
        'rate',
        'effective_from',
        'effective_to',
        'legal_basis',
        'source_url',
        'verified_at',
        'published_at',
        'metadata',
    ];

    protected function casts(): array
    {
        return [
            'rate' => 'decimal:2',
            'effective_from' => 'date',
            'effective_to' => 'date',
            'verified_at' => 'datetime',
            'published_at' => 'datetime',
            'metadata' => 'array',
        ];
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function scopeIndexable(Builder $query): Builder
    {
        return $query
            ->where(function (Builder $source) {
                $source
                    ->where('source_url', 'like', 'https://%')
                    ->orWhere('source_url', 'like', 'http://%');
            })
            ->whereNotNull('verified_at')
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->whereHas('country', fn (Builder $country) => $country->where('is_eu_member', true));
    }

    public function scopeCurrent(Builder $query): Builder
    {
        return $query
            ->whereNotNull('effective_from')
            ->where(function (Builder $effectiveFrom) {
                $effectiveFrom->whereDate('effective_from', '<=', today());
            })
            ->where(function (Builder $effectiveTo) {
                $effectiveTo
                    ->whereNull('effective_to')
                    ->orWhereDate('effective_to', '>=', today());
            });
    }
}
