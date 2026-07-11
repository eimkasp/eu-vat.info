<?php

namespace App\Services;

use App\Models\Country;
use App\Models\VatRateChange;
use App\Support\Seo\SeoPolicy;
use Carbon\CarbonImmutable;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;

class SitemapGenerator
{
    public const SECTIONS = ['core', 'countries', 'validators', 'changes', 'categories', 'editorial'];

    public function __construct(
        protected SeoPolicy $seoPolicy,
        protected BlogPostRepository $blogPosts,
        protected Seo\VatCategorySeoService $vatCategories,
    ) {
    }

    public function generate(): string
    {
        return $this->generateIndex();
    }

    public function generateIndex(): string
    {
        $xml = '<?xml version="1.0" encoding="UTF-8"?>'."\n";
        $xml .= '<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'."\n";

        foreach (self::SECTIONS as $section) {
            $xml .= "    <sitemap>\n";
            $xml .= '        <loc>'.$this->escape($this->seoPolicy->canonicalHost().'/sitemaps/'.$section.'.xml')."</loc>\n";
            $xml .= '        <lastmod>'.$this->sectionLastModified($section)."</lastmod>\n";
            $xml .= "    </sitemap>\n";
        }

        return $xml."</sitemapindex>\n";
    }

    public function generateSection(string $section): string
    {
        abort_unless(in_array($section, self::SECTIONS, true), 404);

        $xml = '<?xml version="1.0" encoding="UTF-8"?>'."\n";
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"'."\n";
        $xml .= '        xmlns:xhtml="http://www.w3.org/1999/xhtml">'."\n";

        foreach ($this->recordsFor($section) as $record) {
            foreach ($this->seoPolicy->indexableLocales() as $locale) {
                $xml .= $this->urlEntry($record['path'], $record['lastmod'], $locale);
            }
        }

        return $xml."</urlset>\n";
    }

    public function writeToFile(): string
    {
        $directory = storage_path('app/seo');
        File::ensureDirectoryExists($directory);
        $path = $directory.'/sitemap.xml';
        File::put($path, $this->generateIndex());

        return $path;
    }

    public function getBaseUrl(): string
    {
        return $this->seoPolicy->canonicalHost();
    }

    public function setBaseUrl(string $url): self
    {
        config()->set('seo.canonical_url', rtrim($url, '/'));

        return $this;
    }

    protected function recordsFor(string $section): Collection
    {
        return match ($section) {
            'core' => $this->coreRecords(),
            'countries' => $this->countryRecords('/vat-calculator'),
            'validators' => $this->countryRecords('/vat-number-validator'),
            'changes' => $this->changeRecords(),
            'categories' => $this->categoryRecords(),
            'editorial' => $this->editorialRecords(),
        };
    }

    protected function coreRecords(): Collection
    {
        $lastmod = $this->filesLastModified([
            resource_path('views/livewire/home.blade.php'),
            resource_path('views/livewire/vat-calculator.blade.php'),
            base_path('routes/web.php'),
        ]);

        $euCountries = Country::query()
            ->where('is_eu_member', true)
            ->get(['slug', 'updated_at'])
            ->keyBy('slug');
        $latestCountryUpdate = $euCountries->max('updated_at');
        $datasetLastmod = $latestCountryUpdate
            ? CarbonImmutable::parse($latestCountryUpdate)->toAtomString()
            : $lastmod;

        $records = collect([
            ['path' => '/', 'lastmod' => $lastmod],
            ['path' => '/vat-calculator', 'lastmod' => $lastmod],
            ['path' => '/vat-number-validator', 'lastmod' => $lastmod],
            ['path' => '/vat-validation-api', 'lastmod' => $lastmod],
            ['path' => '/vat-map', 'lastmod' => $lastmod],
            ['path' => '/tools', 'lastmod' => $lastmod],
            ['path' => '/top-vat-calculations', 'lastmod' => $lastmod],
            ['path' => '/datasets/eu-vat-rates', 'lastmod' => $datasetLastmod],
            ['path' => '/sitemap', 'lastmod' => $lastmod],
        ]);

        $existingSlugs = $euCountries->keys()->all();

        foreach (config('seo.comparisons', []) as $pair) {
            if (count(array_intersect($pair, $existingSlugs)) === 2) {
                $comparisonLastmod = collect($pair)
                    ->map(fn (string $slug) => $euCountries->get($slug)?->updated_at)
                    ->filter()
                    ->max();

                $records->push([
                    'path' => '/compare/'.implode('-vs-', $pair).'-vat',
                    'lastmod' => $comparisonLastmod
                        ? CarbonImmutable::parse($comparisonLastmod)->toAtomString()
                        : $lastmod,
                ]);
            }
        }

        foreach (array_keys(config('vat-scenarios', [])) as $scenario) {
            $records->push([
                'path' => '/vat-guides/'.$scenario,
                'lastmod' => $this->filesLastModified([
                    config_path('vat-scenarios.php'),
                    resource_path('views/livewire/vat-scenario-guide.blade.php'),
                ]),
            ]);
        }

        return $records;
    }

    protected function countryRecords(string $prefix): Collection
    {
        return Country::query()
            ->where('is_eu_member', true)
            ->orderBy('slug')
            ->get()
            ->map(fn (Country $country) => [
                'path' => $prefix.'/'.$country->slug,
                'lastmod' => ($country->updated_at ?? now())->toAtomString(),
            ]);
    }

    protected function changeRecords(): Collection
    {
        $latest = VatRateChange::query()
            ->whereHas('country', fn ($query) => $query->where('is_eu_member', true))
            ->max('updated_at');
        $lastmod = $latest
            ? CarbonImmutable::parse($latest)->toAtomString()
            : $this->filesLastModified([resource_path('views/livewire/vat-changes-history.blade.php')]);

        $records = collect([
            ['path' => '/vat-changes', 'lastmod' => $lastmod],
        ]);

        Country::query()
            ->where('is_eu_member', true)
            ->withMax('vatRates', 'updated_at')
            ->withMax('vatRateChanges', 'updated_at')
            ->where(function ($query) {
                $query->whereHas('vatRates')->orWhereHas('vatRateChanges');
            })
            ->get()
            ->each(function (Country $country) use ($records) {
                $lastModified = collect([
                    $country->updated_at,
                    $country->vat_rates_max_updated_at,
                    $country->vat_rate_changes_max_updated_at,
                ])->filter()
                    ->map(fn ($timestamp) => CarbonImmutable::parse($timestamp))
                    ->sortDesc()
                    ->first();

                $records->push([
                    'path' => '/vat-rates/'.$country->slug.'/history',
                    'lastmod' => ($lastModified ?? now()->startOfDay()->toImmutable())->toAtomString(),
                ]);
            });

        $changes = VatRateChange::query()
            ->with('country')
            ->whereHas('country', fn ($query) => $query->where('is_eu_member', true))
            ->get();

        foreach ($changes as $change) {
            $records->push([
                'path' => '/vat-changes/'.$change->country->slug.'/'.$change->rate_type.'/'.$change->change_date->toDateString(),
                'lastmod' => $change->updated_at->toAtomString(),
            ]);
        }

        foreach ($changes->pluck('change_date')->map->year->unique()->sort() as $year) {
            $yearLastmod = $changes->filter(fn ($change) => $change->change_date->year === $year)->max('updated_at');
            $records->push([
                'path' => '/vat-changes/year/'.$year,
                'lastmod' => $yearLastmod->toAtomString(),
            ]);
        }

        $upcoming = $changes->filter(fn ($change) => $change->change_date->isFuture());
        if ($upcoming->isNotEmpty()) {
            $records->push([
                'path' => '/vat-changes/upcoming',
                'lastmod' => $upcoming->max('updated_at')->toAtomString(),
            ]);
        }

        return $records;
    }

    protected function editorialRecords(): Collection
    {
        $records = collect([
            [
                'path' => '/blog',
                'lastmod' => $this->filesLastModified([resource_path('views/livewire/blog-index.blade.php')]),
            ],
        ]);

        return $records->concat($this->blogPosts->all()->map(fn (array $post) => [
            'path' => '/blog/'.$post['slug'],
            'lastmod' => $post['updated_at']->toAtomString(),
        ]));
    }

    protected function categoryRecords(): Collection
    {
        $records = collect();
        $categories = $this->vatCategories->eligibleCategories();

        if ($categories->isNotEmpty()) {
            $lastModified = CarbonImmutable::parse($categories->max('last_verified_at'))->toAtomString();
            $records->push([
                'path' => '/vat-rates/categories',
                'lastmod' => $lastModified,
            ]);

            foreach ($categories as $category) {
                $records->push([
                    'path' => '/vat-rates/categories/'.$category['slug'],
                    'lastmod' => CarbonImmutable::parse($category['last_verified_at'])->toAtomString(),
                ]);
            }
        }

        foreach ($this->vatCategories->currentRules() as $rule) {
            $lastModified = $rule->verified_at->greaterThan($rule->updated_at)
                ? $rule->verified_at
                : $rule->updated_at;

            $records->push([
                'path' => '/vat-rates/'.$rule->country->slug.'/categories/'.$rule->category_slug,
                'lastmod' => $lastModified->toAtomString(),
            ]);
        }

        return $records;
    }

    protected function urlEntry(string $path, string $lastmod, string $locale): string
    {
        $url = $this->seoPolicy->localizedUrl($path, $locale);
        $entry = "    <url>\n";
        $entry .= '        <loc>'.$this->escape($url)."</loc>\n";
        $entry .= '        <lastmod>'.$this->escape($lastmod)."</lastmod>\n";

        foreach ($this->seoPolicy->indexableLocales() as $alternateLocale) {
            $alternate = $this->seoPolicy->localizedUrl($path, $alternateLocale);
            $entry .= '        <xhtml:link rel="alternate" hreflang="'.$alternateLocale.'" href="'.$this->escape($alternate).'" />'."\n";
        }

        $entry .= '        <xhtml:link rel="alternate" hreflang="x-default" href="'.$this->escape($this->seoPolicy->localizedUrl($path, 'en')).'" />'."\n";

        return $entry."    </url>\n";
    }

    protected function sectionLastModified(string $section): string
    {
        return $this->recordsFor($section)
            ->pluck('lastmod')
            ->filter()
            ->max() ?? now()->startOfDay()->toAtomString();
    }

    protected function filesLastModified(array $files): string
    {
        $timestamp = collect($files)
            ->filter(fn (string $file) => File::exists($file))
            ->map(fn (string $file) => File::lastModified($file))
            ->max() ?? now()->startOfDay()->timestamp;

        return CarbonImmutable::createFromTimestamp($timestamp)->toAtomString();
    }

    protected function escape(string $value): string
    {
        return htmlspecialchars($value, ENT_XML1 | ENT_QUOTES, 'UTF-8');
    }
}
