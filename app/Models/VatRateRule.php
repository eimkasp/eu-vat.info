<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\ValidationException;

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

    protected static function booted(): void
    {
        static::saving(function (VatRateRule $rule) {
            if ($rule->source_url !== null && ! static::hasValidSourceUrl($rule->source_url)) {
                throw ValidationException::withMessages([
                    'source_url' => 'The source URL must be a valid HTTP or HTTPS URL.',
                ]);
            }
        });
    }

    public static function hasValidSourceUrl(?string $url): bool
    {
        if (! is_string($url) || trim($url) === '' || filter_var($url, FILTER_VALIDATE_URL) === false) {
            return false;
        }

        return in_array(parse_url($url, PHP_URL_SCHEME), ['http', 'https'], true);
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
            ->where('source_url', 'not like', '% %')
            ->whereRaw('LENGTH(source_url) >= 12')
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
