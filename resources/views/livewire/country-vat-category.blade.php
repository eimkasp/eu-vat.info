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
        :description="'The verified '.$rule->category_name.' VAT rate in '.$country->name.' is '.\App\Models\Country::formatRate($rule->rate).'%. Review its classification, effective period and source.'"
        :url="$canonical">
        <script type="application/ld+json">{!! json_encode([
            '@@context' => 'https://schema.org',
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
        ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG) !!}</script>
    </x-seo-meta>
@endsection

<div>
    <x-page-header
        :title="$title"
        :description="'A source-backed reference for the currently published '.strtolower($rule->category_name).' classification in '.$country->name.'.'"
        eyebrow="Verified country rule"
        :breadcrumbs="[$country->name.' VAT calculator' => locale_path('/vat-calculator/'.$country->slug), $rule->category_name => '']"
    />

    <div class="app-container space-y-6 py-8 sm:py-10">
        <div class="grid grid-cols-1 items-start gap-8 lg:grid-cols-[minmax(0,1fr)_20rem]">
            <div class="min-w-0 space-y-6">
                <section class="app-surface overflow-hidden" aria-label="{{ $title }}">
                    <div class="flex items-center gap-4 border-b border-line p-5 sm:p-6">
                        <x-ui.flag :iso="$country->iso_code" size="xl" :lazy="false" />
                        <div>
                            <p class="text-[0.8125rem] font-semibold text-ink-muted">VAT rate</p>
                            <p class="tabular text-4xl font-bold tracking-[-0.03em] text-ink">{{ \App\Models\Country::formatRate($rule->rate) }}%</p>
                        </div>
                    </div>
                    <dl class="divide-y divide-line text-sm">
                        <div class="grid gap-1 px-5 py-3.5 sm:grid-cols-[11rem_minmax(0,1fr)] sm:px-6">
                            <dt class="text-ink-muted">Classification</dt>
                            <dd class="font-semibold text-ink">{{ str($rule->rate_type)->replace('_', '-')->ucfirst() }} rate</dd>
                        </div>
                        <div class="grid gap-1 px-5 py-3.5 sm:grid-cols-[11rem_minmax(0,1fr)] sm:px-6">
                            <dt class="text-ink-muted">Effective period</dt>
                            <dd class="tabular text-ink">{{ $rule->effective_from?->format('j F Y') ?? 'Start date not specified' }} – {{ $rule->effective_to?->format('j F Y') ?? 'Current' }}</dd>
                        </div>
                        @if($rule->legal_basis)
                            <div class="grid gap-1 px-5 py-3.5 sm:grid-cols-[11rem_minmax(0,1fr)] sm:px-6">
                                <dt class="text-ink-muted">Legal basis</dt>
                                <dd class="max-w-2xl leading-6 text-ink">{{ $rule->legal_basis }}</dd>
                            </div>
                        @endif
                    </dl>
                </section>

                <nav class="flex flex-wrap gap-2" aria-label="Related pages">
                    <a class="app-button-secondary" href="{{ locale_path('/vat-calculator/'.$country->slug) }}">
                        <x-ui.icon name="calculator" class="size-4" />
                        Calculate {{ $country->name }} VAT
                    </a>
                    @if($categoryHubAvailable)
                        <a class="app-button-secondary" href="{{ locale_path('/vat-rates/categories/'.$rule->category_slug) }}">
                            <x-ui.icon name="grid" class="size-4" />
                            Compare {{ strtolower($rule->category_name) }} rates
                        </a>
                    @endif
                    @if($country->hasVatHistory())
                        <a class="app-button-secondary" href="{{ locale_path('/vat-rates/'.$country->slug.'/history') }}">
                            <x-ui.icon name="history" class="size-4" />
                            View rate history
                        </a>
                    @endif
                </nav>
            </div>

            <aside class="app-surface p-5 lg:sticky lg:top-24">
                <h2 class="text-base font-bold text-ink">Source and verification</h2>
                <dl class="mt-3 divide-y divide-line border-t border-line text-sm">
                    <div class="flex justify-between gap-4 py-2.5">
                        <dt class="text-ink-muted">Verified</dt>
                        <dd class="tabular font-semibold text-ink">{{ $rule->verified_at->format('j F Y') }}</dd>
                    </div>
                    <div class="flex justify-between gap-4 py-2.5">
                        <dt class="text-ink-muted">Recorded source</dt>
                        <dd>
                            <a class="inline-flex items-center gap-1 font-semibold text-action hover:text-action-deep hover:underline" href="{{ $rule->source_url }}" rel="noopener">
                                Official source
                                <x-ui.icon name="arrow-up-right" class="size-3.5" />
                            </a>
                        </dd>
                    </div>
                </dl>
            </aside>
        </div>

        <p class="app-note">
            <x-ui.icon name="info" class="mt-1 size-4 text-action" />
            <span>This page is a data reference, not transaction-specific tax advice. The applicable treatment can depend on precise product classification, customer status, place of supply, exemptions and current national guidance.</span>
        </p>
    </div>
</div>
