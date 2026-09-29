<?php

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;

/*
 * public/v1 is a frozen static snapshot of the site before the 5.0 redesign. These guards keep it
 * complete, self-contained, out of search results and free of anything that needs a server.
 */

function archivePages(): array
{
    static $pages;

    return $pages ??= collect(File::allFiles(public_path('v1')))
        ->filter(fn ($file) => $file->getFilename() === 'index.html')
        ->mapWithKeys(function ($file) {
            $directory = trim(str_replace('\\', '/', $file->getRelativePath()), '/');

            return [$directory === '' ? '/v1/' : '/v1/'.$directory.'/' => file_get_contents($file->getPathname())];
        })
        ->sortKeys()
        ->all();
}

function archiveReferences(string $html): array
{
    preg_match_all('/(?<=\s)(href|src|srcset)="([^"]*)"/', $html, $matches, PREG_SET_ORDER);

    return collect($matches)
        ->flatMap(fn (array $match) => $match[1] === 'srcset'
            ? collect(explode(',', html_entity_decode($match[2])))->map(fn (string $candidate) => ['src', strtok(trim($candidate), ' ')])
            : [[$match[1], html_entity_decode($match[2])]])
        ->all();
}

function archiveFileExists(string $url): bool
{
    $path = public_path(ltrim(strtok(strtok($url, '#'), '?'), '/'));

    return is_file($path) || is_file(rtrim($path, '/').'/index.html');
}

it('keeps a complete English snapshot of the pre-redesign site', function () {
    $pages = array_keys(archivePages());

    expect($pages)->toHaveCount(246)
        ->toContain('/v1/', '/v1/vat-calculator/', '/v1/vat-number-validator/', '/v1/vat-map/', '/v1/vat-changes/', '/v1/changelog/', '/v1/sitemap/')
        ->and(collect($pages)->filter(fn (string $page) => preg_match('#^/v1/vat-calculator/[a-z-]+/$#', $page))->count())->toBe(32)
        ->and(collect($pages)->filter(fn (string $page) => preg_match('#^/v1/vat-number-validator/[a-z-]+/$#', $page))->count())->toBe(32);
});

it('marks every archived page as an unindexed, read-only snapshot', function () {
    $required = [
        '<meta name="robots" content="noindex, nofollow">',
        '<script src="/v1/archive.js"></script>',
        '<link rel="stylesheet" href="/v1/archive.css">',
        '<aside class="v1-archive-bar" aria-label="Archived version">',
        ' · Archive v1</title>',
        'data-csrf="archive" data-update-uri="/v1/livewire/update"',
    ];

    $forbidden = [
        'rel="canonical"' => 'archived pages must not claim a canonical URL',
        'hreflang=' => 'archived pages must not advertise alternates',
        'application/ld+json' => 'structured data belongs to the live site',
        'property="og:' => 'social previews belong to the live site',
        'serviceWorker' => 'the archive must not register a service worker',
        'modelContext' => 'the archive must not register WebMCP tools',
        '127.0.0.1' => 'links must point at the archive or the live site',
        'flagcdn.com' => 'flags are served from /v1/flags',
    ];

    $violations = [];

    foreach (archivePages() as $page => $html) {
        foreach ($required as $snippet) {
            if (! str_contains($html, $snippet)) {
                $violations[] = "{$page} is missing {$snippet}";
            }
        }

        foreach ($forbidden as $snippet => $reason) {
            if (str_contains($html, $snippet)) {
                $violations[] = "{$page} contains {$snippet}: {$reason}";
            }
        }
    }

    expect($violations)->toBe([]);
});

it('serves every asset from inside the archive and resolves every archive link', function () {
    $violations = [];

    foreach (archivePages() as $page => $html) {
        foreach (archiveReferences($html) as [$attribute, $url]) {
            if ($attribute === 'src' && ! str_starts_with($url, '/v1/') && ! str_starts_with($url, 'data:')) {
                $violations[] = "{$page} loads {$url} from outside the archive";
            }

            if (str_starts_with($url, '/v1/') && ! archiveFileExists($url)) {
                $violations[] = "{$page} references missing {$url}";
            }
        }
    }

    expect($violations)->toBe([])
        ->and(public_path('v1/archive.css'))->toBeFile()
        ->and(public_path('v1/archive.js'))->toBeFile()
        ->and(public_path('v1/livewire/livewire.min.js'))->toBeFile()
        ->and(public_path('v1/flags/LICENSE'))->toBeFile();
});

it('answers the old Livewire runtime in the browser and opens archived calculators', function () {
    $script = file_get_contents(public_path('v1/archive.js'));

    preg_match('/new Set\((\[.*?\])\)/', $script, $match);

    $calculators = collect(array_keys(archivePages()))
        ->map(fn (string $page) => preg_match('#^/v1/vat-calculator/([a-z-]+)/$#', $page, $slug) ? $slug[1] : null)
        ->filter()
        ->values()
        ->all();

    expect($script)->toContain("const updatePath = '/v1/livewire/update';")
        ->and(json_decode($match[1] ?? 'null', true))->toBe($calculators);
});

it('links the archive from the live site without routing or indexing it', function () {
    $routes = collect(Route::getRoutes()->getRoutes())->map->uri();

    expect($routes->filter(fn (string $uri) => $uri === 'v1' || str_starts_with($uri, 'v1/')))->toBeEmpty();

    $this->get('/')->assertOk()->assertSee('href="/v1/"', false);
    $this->get('/changelog')->assertOk()->assertSee('href="/v1/"', false);
    $this->get('/sitemaps/core.xml')->assertOk()->assertDontSee('/v1', false);
    $this->get('/sitemaps/editorial.xml')->assertOk()->assertDontSee('/v1', false);
});
