<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Spatie\Sitemap\Contracts\Sitemapable;
use Spatie\Sitemap\Tags\Url;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use App\Traits\HasAnalytics;

class Country extends Model implements Sitemapable , Auditable
{
    use \OwenIt\Auditing\Auditable;
    use HasFactory;
    use HasSlug;
    use HasAnalytics;

    protected $auditExclude = [
        'id',
    ];

    protected $fillable = [
    'iso_code',
    'iso_code_2',
    'name',
    'slug',
    'standard_rate',
    'reduced_rate',
    'super_reduced_rate',
    'zero_rate',
    'parking_rate',
    'currency',
    'currency_code',
    'currency_symbol',
    'flag'
    ];

    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }

    public function countryRank()
    {
        // Find the rank of the country based on the standard rate
        return Country::where('standard_rate', '<', $this->standard_rate)->count() + 1;
    }

    public function toSitemapTag(): Url|string|array
    {
        // Simple return:
        return [route('country.show', $this->slug), route('vat-calculator.country', $this->slug)];
    }

    public function analytics()
    {
        return $this->hasMany(CountryAnalytic::class);
    }

    public function vatRates()
    {
        return $this->hasMany(VatRate::class);
    }
}
