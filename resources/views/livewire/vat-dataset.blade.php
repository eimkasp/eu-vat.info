@php
    $canonical = app(\App\Support\Seo\SeoPolicy::class)->canonicalHost().locale_path('/datasets/eu-vat-rates');
    $baseUrl = app(\App\Support\Seo\SeoPolicy::class)->canonicalHost();
    $schema = [
        '@context' => 'https://schema.org',
        '@graph' => [
            [
                '@type' => 'BreadcrumbList',
                '@id' => $canonical.'#breadcrumbs',
                'itemListElement' => [
                    ['@type' => 'ListItem', 'position' => 1, 'name' => 'EU VAT Info', 'item' => $baseUrl.'/'],
                    ['@type' => 'ListItem', 'position' => 2, 'name' => 'EU VAT rates dataset', 'item' => $canonical],
                ],
            ],
            [
                '@type' => 'Dataset',
                '@id' => $canonical.'#dataset',
                'name' => 'EU VAT Rates Dataset',
                'description' => 'Current standard, reduced, super-reduced and parking VAT rates for the 27 European Union member states.',
                'url' => $canonical,
                'dateModified' => $dateModified->toIso8601String(),
                'license' => 'https://creativecommons.org/licenses/by/4.0/',
                'isAccessibleForFree' => true,
                'spatialCoverage' => 'European Union',
                'temporalCoverage' => '2000/'.now()->year,
                'isBasedOn' => [
                    'https://taxation-customs.ec.europa.eu/taxation/vat_en',
                    'https://github.com/kdeldycke/vat-rates',
                ],
                'creator' => [
                    '@type' => 'Organization',
                    '@id' => $baseUrl.'/#organization',
                    'name' => 'EU VAT Info',
                    'url' => $baseUrl,
                ],
                'variableMeasured' => [
                    ['@type' => 'PropertyValue', 'name' => 'Standard VAT rate', 'unitText' => 'percent'],
                    ['@type' => 'PropertyValue', 'name' => 'Reduced VAT rate', 'unitText' => 'percent'],
                    ['@type' => 'PropertyValue', 'name' => 'Super-reduced VAT rate', 'unitText' => 'percent'],
                    ['@type' => 'PropertyValue', 'name' => 'Parking VAT rate', 'unitText' => 'percent'],
                ],
                'distribution' => [
                    ['@type' => 'DataDownload', 'encodingFormat' => 'text/csv', 'contentUrl' => $baseUrl.'/datasets/eu-vat-rates.csv'],
                    ['@type' => 'DataDownload', 'encodingFormat' => 'application/json', 'contentUrl' => $baseUrl.'/api/countries'],
                    ['@type' => 'DataDownload', 'encodingFormat' => 'text/markdown', 'contentUrl' => $baseUrl.'/llms-full.txt'],
                ],
            ],
        ],
    ];
@endphp

@section('seo')
    <x-seo-meta
        title="EU VAT Rates Dataset — Current Rates, History and Downloads"
        description="Download current VAT rates for all 27 EU member states as CSV, JSON or Markdown, with source provenance and verification dates."
        :url="$canonical">
        <script type="application/ld+json">{!! json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}</script>
    </x-seo-meta>
@endsection

<div class="container pb-14 pt-8 sm:pt-12">
    <x-breadcrumbs :items="['EU VAT rates dataset' => '']" />

    <header class="max-w-3xl border-b border-line pb-8">
        <p class="mb-3 text-sm font-semibold text-action">Open VAT data</p>
        <h1 class="text-3xl font-bold tracking-tight text-ink sm:text-4xl">EU VAT rates dataset</h1>
        <p class="mt-4 max-w-2xl text-lg text-ink-muted">
            Current VAT rate data for {{ $countries->count() }} EU member states, available in formats suited to analysis, integrations and research.
        </p>
        <p class="mt-3 text-sm text-ink-muted">Last updated {{ $dateModified->format('F j, Y') }}.</p>
    </header>

    <div class="mt-8 grid gap-8 lg:grid-cols-[minmax(0,1fr)_320px]">
        <section aria-labelledby="dataset-downloads">
            <h2 id="dataset-downloads" class="text-2xl font-bold text-ink">Download the data</h2>
            <div class="mt-4 divide-y divide-line border-y border-line">
                <a href="/datasets/eu-vat-rates.csv" class="flex min-h-16 items-center justify-between gap-4 py-4 text-ink hover:text-action">
                    <span><strong class="block">CSV</strong><span class="text-sm text-ink-muted">Spreadsheet and analysis workflows</span></span>
                    <span aria-hidden="true">Download →</span>
                </a>
                <a href="/api/countries" class="flex min-h-16 items-center justify-between gap-4 py-4 text-ink hover:text-action">
                    <span><strong class="block">JSON API</strong><span class="text-sm text-ink-muted">Applications and data pipelines</span></span>
                    <span aria-hidden="true">Open →</span>
                </a>
                <a href="/llms-full.txt" class="flex min-h-16 items-center justify-between gap-4 py-4 text-ink hover:text-action">
                    <span><strong class="block">Markdown</strong><span class="text-sm text-ink-muted">Research and language-model context</span></span>
                    <span aria-hidden="true">Open →</span>
                </a>
            </div>

            <h2 class="mt-10 text-2xl font-bold text-ink">What is included</h2>
            <p class="mt-3 max-w-3xl text-ink-muted">Each row includes the country, ISO code, standard rate, available reduced-rate fields, currency and record update time. Historical records are published separately through each country’s VAT history.</p>
        </section>

        <aside class="app-surface p-5">
            <h2 class="text-lg font-bold text-ink">Provenance</h2>
            <p class="mt-3 text-sm text-ink-muted">Rates are aggregated from European Commission material and the open VAT Rates dataset, then checked by the project’s data-integrity workflow.</p>
            <dl class="mt-5 space-y-4 text-sm">
                <div><dt class="font-semibold text-ink">Coverage</dt><dd class="text-ink-muted">European Union</dd></div>
                <div><dt class="font-semibold text-ink">License</dt><dd><a class="text-action hover:underline" href="https://creativecommons.org/licenses/by/4.0/">CC BY 4.0</a></dd></div>
                <div><dt class="font-semibold text-ink">Member states</dt><dd class="text-ink-muted">{{ $countries->count() }}</dd></div>
            </dl>
        </aside>
    </div>
</div>
