<?php

namespace App\Services\Seo;

use App\Support\Seo\SeoPolicy;
use Illuminate\Support\Facades\Http;

class IndexNowService
{
    public function __construct(protected SeoPolicy $seoPolicy)
    {
    }

    public function submit(array $urls): bool
    {
        $key = config('seo.indexnow.key');

        if (! config('seo.indexnow.enabled') || ! is_string($key) || $key === '') {
            return false;
        }

        $canonicalHost = parse_url($this->seoPolicy->canonicalHost(), PHP_URL_HOST);
        $canonicalUrls = collect($urls)
            ->filter(fn ($url) => is_string($url)
                && parse_url($url, PHP_URL_SCHEME) === 'https'
                && parse_url($url, PHP_URL_HOST) === $canonicalHost)
            ->unique()
            ->take(10_000)
            ->values()
            ->all();

        if ($canonicalUrls === []) {
            return false;
        }

        $response = Http::asJson()
            ->timeout(10)
            ->post(config('seo.indexnow.endpoint'), [
                'host' => $canonicalHost,
                'key' => $key,
                'keyLocation' => $this->seoPolicy->canonicalHost().'/indexnow-key.txt',
                'urlList' => $canonicalUrls,
            ]);

        return $response->successful();
    }
}
