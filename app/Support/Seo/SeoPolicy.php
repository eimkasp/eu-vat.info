<?php

namespace App\Support\Seo;

class SeoPolicy
{
    public function canonicalHost(): string
    {
        return rtrim((string) config('seo.canonical_url', 'https://vat.businesspress.io'), '/');
    }

    public function indexableLocales(): array
    {
        return array_values(array_unique(config('seo.indexable_locales', ['en'])));
    }

    public function isLocaleIndexable(string $locale): bool
    {
        return in_array($locale, $this->indexableLocales(), true);
    }

    public function robotsForCurrentLocale(): string
    {
        return $this->isLocaleIndexable(app()->getLocale())
            ? 'index, follow'
            : 'noindex, follow';
    }

    public function shouldEmitHreflang(): bool
    {
        return $this->isLocaleIndexable(app()->getLocale())
            && ! request()->routeIs('shared-calculation', 'locale.shared-calculation');
    }

    public function localizedUrl(string $path, string $locale): string
    {
        $default = config('translation.default_language', 'en');
        $path = '/'.ltrim($path, '/');
        $path = $path === '/' ? '' : $path;

        if ($locale === $default) {
            return $this->canonicalHost().($path ?: '/');
        }

        return $this->canonicalHost().'/'.$locale.$path;
    }

    public function canonicalizeLocalUrl(string $url): string
    {
        $parts = parse_url($url);
        $host = $parts['host'] ?? null;
        $canonicalHost = parse_url($this->canonicalHost(), PHP_URL_HOST);
        $localHosts = array_merge(
            [$canonicalHost, request()->getHost()],
            config('seo.legacy_hosts', [])
        );

        if ($host && ! in_array($host, array_filter($localHosts), true)) {
            return $url;
        }

        $path = $parts['path'] ?? '/';
        $query = isset($parts['query']) ? '?'.$parts['query'] : '';

        return $this->canonicalHost().($path === '' ? '/' : $path).$query;
    }
}
