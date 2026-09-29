@php
    $baseUrl = app(\App\Support\Seo\SeoPolicy::class)->canonicalHost();
    $path = '/vat-rates/categories/'.$summary['slug'];
    $canonical = $baseUrl.locale_path($path);
    $title = $summary['name'].' VAT rates across the EU';
    $dateModified = \Carbon\CarbonImmutable::parse($summary['last_verified_at']);
@endphp

@section('seo')
    <x-seo-meta
        :title="$title.' — Verified Country Comparison'"
        :description="'Compare verified '.$summary['name'].' VAT rates across '.$summary['country_count'].' EU countries, with effective dates and source links.'"
        :url="$canonical">
        <script type="application/ld+json">{!! json_encode([
            '@@context' => 'https://schema.org',
            '@graph' => [
                [
                    '@type' => 'BreadcrumbList',
                    '@id' => $canonical.'#breadcrumbs',
                    'itemListElement' => [
                        ['@type' => 'ListItem', 'position' => 1, 'name' => 'EU VAT Info', 'item' => $baseUrl.'/'],
                        ['@type' => 'ListItem', 'position' => 2, 'name' => 'VAT rate categories', 'item' => $baseUrl.'/vat-rates/categories'],
                        ['@type' => 'ListItem', 'position' => 3, 'name' => $summary['name'], 'item' => $canonical],
                    ],
                ],
                [
                    '@type' => 'CollectionPage',
                    '@id' => $canonical.'#webpage',
                    'name' => $title,
                    'url' => $canonical,
                    'dateModified' => $dateModified->toIso8601String(),
                    'mainEntity' => [
                        '@type' => 'ItemList',
                        'numberOfItems' => $rules->count(),
                        'itemListElement' => $rules->values()->map(fn ($rule, int $index) => [
                            '@type' => 'ListItem',
                            'position' => $index + 1,
                            'name' => $rule->country->name.' '.$summary['name'].' VAT rate',
                            'url' => $baseUrl.'/vat-rates/'.$rule->country->slug.'/categories/'.$summary['slug'],
                        ])->all(),
                    ],
                ],
            ],
        ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG) !!}</script>
    </x-seo-meta>
@endsection

<div>
    <x-page-header
        :title="$title"
        :description="'Compare '.strtolower($summary['name']).' VAT rules currently verified for '.$summary['country_count'].' EU countries. Each row links to the country rule and recorded source.'"
        eyebrow="Category comparison"
        :breadcrumbs="['VAT rate categories' => locale_path('/vat-rates/categories'), $summary['name'] => '']"
    >
        <x-slot:actions>
            <span class="inline-flex items-center gap-2 rounded-control border border-line bg-surface-subtle px-3 py-1.5 text-sm text-ink-muted">
                <x-ui.icon name="check-circle" class="size-4" />
                <span>Last verified <time class="tabular" datetime="{{ $dateModified->toDateString() }}">{{ $dateModified->format('j F Y') }}</time></span>
            </span>
        </x-slot:actions>
    </x-page-header>

    <div class="app-container space-y-6 py-8 sm:py-10">
        <section class="app-surface overflow-hidden" aria-label="{{ $title }}">
            <div class="relative overflow-x-auto">
                <table class="app-table min-w-[44rem]">
                    <thead>
                        <tr>
                            <th scope="col" class="pl-5 sm:pl-6">Country</th>
                            <th scope="col" class="text-right">Rate</th>
                            <th scope="col">Classification</th>
                            <th scope="col">Effective from</th>
                            <th scope="col" class="pr-5 sm:pr-6">Source</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($rules as $rule)
                            <tr class="transition-colors hover:bg-surface-subtle">
                                <td class="pl-5 sm:pl-6">
                                    <a class="flex min-h-10 items-center gap-3 font-semibold text-ink hover:text-action" href="{{ locale_path('/vat-rates/'.$rule->country->slug.'/categories/'.$rule->category_slug) }}">
                                        <x-ui.flag :iso="$rule->country->iso_code" size="lg" class="h-5 w-[1.625rem]" />
                                        {{ $rule->country->name }}
                                    </a>
                                </td>
                                <td class="tabular text-right text-base font-bold text-ink">{{ \App\Models\Country::formatRate($rule->rate) }}%</td>
                                <td class="text-ink">{{ str($rule->rate_type)->replace('_', '-')->ucfirst() }}</td>
                                <td class="tabular text-ink-muted">{{ $rule->effective_from?->format('j M Y') ?? 'Not specified' }}</td>
                                <td class="pr-5 sm:pr-6">
                                    <a class="inline-flex items-center gap-1 font-semibold text-action hover:text-action-deep hover:underline" href="{{ $rule->source_url }}" rel="nofollow noopener">
                                        Official source
                                        <x-ui.icon name="arrow-up-right" class="size-3.5" />
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </section>

        <p class="app-note">
            <x-ui.icon name="info" class="mt-1 size-4 text-action" />
            <span>Rates are references, not transaction-specific tax advice. Product classification, customer status and place-of-supply rules can change the applicable treatment.</span>
        </p>
    </div>
</div>
