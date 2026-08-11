@php
    $country = $rule->country;
    $baseUrl = app(\App\Support\Seo\SeoPolicy::class)->canonicalHost();
    $path = '/vat-rates/'.$country->slug.'/categories/'.$rule->category_slug;
    $canonical = $baseUrl.locale_path($path);
    $title = $rule->category_name.' VAT rate in '.$country->name;
    $dateModified = $rule->verified_at->greaterThan($rule->updated_at) ? $rule->verified_at : $rule->updated_at;
@endphp

@section('seo')
    <x-seo-meta
        :title="$title.' — Verified Rate and Source'"
        :description="'The verified '.$rule->category_name.' VAT rate in '.$country->name.' is '.number_format((float) $rule->rate, 2).'%. Review its classification, effective period and source.'"
        :url="$canonical">
        <script type="application/ld+json">{!! json_encode([
            '@context' => 'https://schema.org',
            '@graph' => [
                [
                    '@type' => 'BreadcrumbList',
                    '@id' => $canonical.'#breadcrumbs',
                    'itemListElement' => [
                        ['@type' => 'ListItem', 'position' => 1, 'name' => 'EU VAT Info', 'item' => $baseUrl.'/'],
                        ['@type' => 'ListItem', 'position' => 2, 'name' => $country->name.' VAT calculator', 'item' => $baseUrl.'/vat-calculator/'.$country->slug],
                        ['@type' => 'ListItem', 'position' => 3, 'name' => $title, 'item' => $canonical],
                    ],
                ],
                [
                    '@type' => 'WebPage',
                    '@id' => $canonical.'#webpage',
                    'name' => $title,
                    'url' => $canonical,
                    'dateModified' => $dateModified->toIso8601String(),
                    'about' => [
                        '@type' => 'DefinedTerm',
                        'name' => $rule->category_name,
                        'termCode' => $rule->category_slug,
                    ],
                    'spatialCoverage' => [
                        '@type' => 'Country',
                        'name' => $country->name,
                    ],
                    'isBasedOn' => $rule->source_url,
                ],
            ],
        ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}</script>
    </x-seo-meta>
@endsection

<div class="container pb-14 pt-8 sm:pt-12">
    <x-site-breadcrumbs :items="[$country->name.' VAT calculator' => locale_path('/vat-calculator/'.$country->slug), $rule->category_name => '']" />

    <header class="max-w-4xl border-b border-line pb-8">
        <div class="flex items-center gap-3">
            <img src="https://flagcdn.com/h80/{{ strtolower($country->iso_code) }}.jpg" alt="" class="h-7 w-10 rounded-sm object-cover">
            <p class="text-sm font-semibold text-action">Verified country rule</p>
        </div>
        <h1 class="mt-4 text-3xl font-bold tracking-tight text-ink sm:text-4xl">{{ $title }}</h1>
        <p class="mt-4 max-w-3xl text-lg text-ink-muted">A source-backed reference for the currently published {{ strtolower($rule->category_name) }} classification in {{ $country->name }}.</p>
    </header>

    <div class="mt-8 grid gap-8 lg:grid-cols-[minmax(0,1fr)_320px]">
        <main>
            <dl class="divide-y divide-line border-y border-line">
                <div class="grid gap-2 py-5 sm:grid-cols-[180px_minmax(0,1fr)] sm:items-baseline">
                    <dt class="text-sm font-semibold text-ink-muted">VAT rate</dt>
                    <dd class="text-3xl font-bold tabular-nums text-ink">{{ number_format((float) $rule->rate, 2) }}%</dd>
                </div>
                <div class="grid gap-2 py-5 sm:grid-cols-[180px_minmax(0,1fr)]">
                    <dt class="text-sm font-semibold text-ink-muted">Classification</dt>
                    <dd class="font-semibold text-ink">{{ str($rule->rate_type)->replace('_', ' ')->title() }} rate</dd>
                </div>
                <div class="grid gap-2 py-5 sm:grid-cols-[180px_minmax(0,1fr)]">
                    <dt class="text-sm font-semibold text-ink-muted">Effective period</dt>
                    <dd class="text-ink">{{ $rule->effective_from?->format('F j, Y') ?? 'Start date not specified' }} – {{ $rule->effective_to?->format('F j, Y') ?? 'Current' }}</dd>
                </div>
                @if($rule->legal_basis)
                    <div class="grid gap-2 py-5 sm:grid-cols-[180px_minmax(0,1fr)]">
                        <dt class="text-sm font-semibold text-ink-muted">Legal basis</dt>
                        <dd class="max-w-2xl leading-7 text-ink">{{ $rule->legal_basis }}</dd>
                    </div>
                @endif
            </dl>

            <div class="mt-8 flex flex-wrap gap-x-5 gap-y-3 text-sm font-semibold">
                <a class="text-action hover:underline" href="{{ locale_path('/vat-calculator/'.$country->slug) }}">Calculate {{ $country->name }} VAT</a>
                @if($categoryHubAvailable)
                    <a class="text-action hover:underline" href="{{ locale_path('/vat-rates/categories/'.$rule->category_slug) }}">Compare {{ strtolower($rule->category_name) }} rates</a>
                @endif
                @if($country->hasVatHistory())
                    <a class="text-action hover:underline" href="{{ locale_path('/vat-rates/'.$country->slug.'/history') }}">View rate history</a>
                @endif
            </div>
        </main>

        <aside class="app-surface p-5">
            <h2 class="text-lg font-bold text-ink">Source and verification</h2>
            <dl class="mt-4 space-y-4 text-sm">
                <div>
                    <dt class="font-semibold text-ink">Verified</dt>
                    <dd class="mt-1 text-ink-muted">{{ $rule->verified_at->format('F j, Y') }}</dd>
                </div>
                <div>
                    <dt class="font-semibold text-ink">Recorded source</dt>
                    <dd class="mt-1"><a class="font-semibold text-action hover:underline" href="{{ $rule->source_url }}" rel="noopener">Official source ↗</a></dd>
                </div>
            </dl>
        </aside>
    </div>

    <p class="mt-10 max-w-3xl text-sm leading-6 text-ink-muted">This page is a data reference, not transaction-specific tax advice. The applicable treatment can depend on precise product classification, customer status, place of supply, exemptions and current national guidance.</p>
</div>
