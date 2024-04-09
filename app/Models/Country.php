<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sitemap\Contracts\Sitemapable;
use Spatie\Sitemap\Tags\Url;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Country extends Model implements Sitemapable
{

    use HasFactory;
    use HasSlug;

    public $with = ['vatHistory'];
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

    public function vatHistory()
    {
        return $this->hasMany(VatHistory::class, 'country_id', 'id')->orderBy('year', 'DESC');
    }
}
