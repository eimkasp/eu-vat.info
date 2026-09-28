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

<div class="app-container pb-14 pt-8 sm:pt-12">
    <x-site-breadcrumbs :items="['VAT rate categories' => locale_path('/vat-rates/categories'), $summary['name'] => '']" />

    <header class="max-w-4xl border-b border-line pb-8">
        <p class="mb-3 text-sm font-semibold text-action">Category comparison</p>
        <h1 class="text-3xl font-bold tracking-tight text-ink sm:text-4xl">{{ $title }}</h1>
        <p class="mt-4 max-w-3xl text-lg text-ink-muted">Compare {{ strtolower($summary['name']) }} VAT rules currently verified for {{ $summary['country_count'] }} EU countries. Each row links to the country rule and recorded source.</p>
        <p class="mt-3 text-sm text-ink-muted">Last verified {{ $dateModified->format('F j, Y') }}.</p>
    </header>

    <div class="relative mt-8 overflow-x-auto border-y border-line">
        <table class="w-full min-w-[760px] text-left">
            <thead class="bg-surface-subtle">
                <tr>
                    <th class="px-4 py-3 text-sm font-semibold text-ink-muted">Country</th>
                    <th class="px-4 py-3 text-sm font-semibold text-ink-muted">Rate</th>
                    <th class="px-4 py-3 text-sm font-semibold text-ink-muted">Classification</th>
                    <th class="px-4 py-3 text-sm font-semibold text-ink-muted">Effective from</th>
                    <th class="px-4 py-3 text-sm font-semibold text-ink-muted">Source</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-line bg-surface">
                @foreach($rules as $rule)
                    <tr>
                        <td class="px-4 py-4">
                            <a class="flex items-center gap-3 font-semibold text-ink hover:text-action" href="{{ locale_path('/vat-rates/'.$rule->country->slug.'/categories/'.$rule->category_slug) }}">
                                <x-ui.flag :iso="$rule->country->iso_code" size="lg" class="h-5 w-7" />
                                {{ $rule->country->name }}
                            </a>
                        </td>
                        <td class="px-4 py-4 text-xl font-bold tabular-nums text-ink">{{ number_format((float) $rule->rate, 2) }}%</td>
                        <td class="px-4 py-4 text-sm text-ink">{{ str($rule->rate_type)->replace('_', ' ')->title() }}</td>
                        <td class="px-4 py-4 text-sm text-ink-muted">{{ $rule->effective_from?->format('M j, Y') ?? 'Not specified' }}</td>
                        <td class="px-4 py-4 text-sm"><a class="font-semibold text-action hover:underline" href="{{ $rule->source_url }}" rel="nofollow noopener">Official source ↗</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <p class="mt-8 max-w-3xl text-sm leading-6 text-ink-muted">Rates are references, not transaction-specific tax advice. Product classification, customer status and place-of-supply rules can change the applicable treatment.</p>
</div>
