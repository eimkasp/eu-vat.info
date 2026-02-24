<?php

namespace App\Services;

use App\Models\Country;

class SitemapGenerator
{
    protected string $baseUrl;
    protected array $locales;
    protected string $defaultLocale;

    public function __construct()
    {
        $this->baseUrl = rtrim(config('app.url'), '/');
        $this->locales = array_keys(config('translation.supported_languages', ['en' => []]));
        $this->defaultLocale = config('translation.default_language', 'en');
    }

    public function setBaseUrl(string $url): self
    {
        $this->baseUrl = rtrim($url, '/');
        return $this;
    }

    public function getBaseUrl(): string
    {
        return $this->baseUrl;
    }

    /**
     * Generate the full sitemap XML string.
     */
    public function generate(): string
    {
        $countries = Country::orderBy('name')->get();

        $xml  = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"' . "\n";
        $xml .= '        xmlns:xhtml="http://www.w3.org/1999/xhtml">' . "\n";

        // ── Static pages ───────────────────────────────────────────
        $staticPages = [
            ['path' => '/',               'changefreq' => 'daily',   'priority' => '1.0'],
            ['path' => '/vat-calculator',  'changefreq' => 'weekly',  'priority' => '0.9'],
            ['path' => '/vat-map',         'changefreq' => 'monthly', 'priority' => '0.8'],
            ['path' => '/vat-changes',     'changefreq' => 'weekly',  'priority' => '0.7'],
            ['path' => '/sitemap',         'changefreq' => 'weekly',  'priority' => '0.5'],
        ];

        foreach ($staticPages as $page) {
            $xml .= $this->urlEntry(
                $page['path'],
                now()->toAtomString(),
                $page['changefreq'],
                $page['priority'],
            );
        }

        // ── Country pages ──────────────────────────────────────────
        foreach ($countries as $country) {
            $lastmod = $country->updated_at?->toAtomString() ?? now()->toAtomString();

            // Country overview
            $xml .= $this->urlEntry(
                '/country/' . $country->slug,
                $lastmod,
                'monthly',
                '0.9',
            );

            // Country VAT calculator (tab URL)
            $xml .= $this->urlEntry(
                '/country/' . $country->slug . '/vat-calculator',
                $lastmod,
                'monthly',
                '0.8',
            );

            // Standalone calculator URL
            $xml .= $this->urlEntry(
                '/vat-calculator/' . $country->slug,
                $lastmod,
                'monthly',
                '0.7',
            );
        }

        // ── Non-localised utility pages (no hreflang) ──────────────
        $utilityPages = [
            ['path' => '/llms.txt',          'priority' => '0.3'],
            ['path' => '/llms-full.txt',     'priority' => '0.3'],
            ['path' => '/api/llm/vat-rates', 'priority' => '0.3'],
        ];

        foreach ($utilityPages as $page) {
            $xml .= "    <url>\n";
            $xml .= '        <loc>' . $this->escape($this->baseUrl . $page['path']) . "</loc>\n";
            $xml .= "        <changefreq>weekly</changefreq>\n";
            $xml .= '        <priority>' . $page['priority'] . "</priority>\n";
            $xml .= "    </url>\n";
        }

        $xml .= "</urlset>\n";

        return $xml;
    }

    /**
     * Write the generated sitemap to public/sitemap.xml
     */
    public function writeToFile(): string
    {
        $path = public_path('sitemap.xml');
        file_put_contents($path, $this->generate());
        return $path;
    }

    /**
     * Build a <url> entry with xhtml:link hreflang alternates for all locales.
     */
    protected function urlEntry(string $path, string $lastmod, string $changefreq, string $priority): string
    {
        // Canonical URL (default locale, no prefix)
        $canonicalUrl = $this->buildUrl($path, $this->defaultLocale);

        $entry  = "    <url>\n";
        $entry .= '        <loc>' . $this->escape($canonicalUrl) . "</loc>\n";
        $entry .= '        <lastmod>' . $lastmod . "</lastmod>\n";
        $entry .= '        <changefreq>' . $changefreq . "</changefreq>\n";
        $entry .= '        <priority>' . $priority . "</priority>\n";

        // hreflang alternates
        foreach ($this->locales as $locale) {
            $localeUrl = $this->buildUrl($path, $locale);
            $entry .= '        <xhtml:link rel="alternate" hreflang="' . $locale . '" href="' . $this->escape($localeUrl) . '" />' . "\n";
        }

        // x-default points to the default locale
        $entry .= '        <xhtml:link rel="alternate" hreflang="x-default" href="' . $this->escape($canonicalUrl) . '" />' . "\n";
        $entry .= "    </url>\n";

        return $entry;
    }

    /**
     * Build a full URL for a given path and locale.
     */
    protected function buildUrl(string $path, string $locale): string
    {
        $path = $path === '/' ? '' : $path;

        if ($locale === $this->defaultLocale) {
            return $this->baseUrl . ($path ?: '/');
        }

        return $this->baseUrl . '/' . $locale . $path;
    }

    protected function escape(string $value): string
    {
        return htmlspecialchars($value, ENT_XML1 | ENT_QUOTES, 'UTF-8');
    }
}
