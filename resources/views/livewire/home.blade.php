@section('seo')
    <x-seo-meta :title="__('ui.home_page.title')" :description="__('ui.home_page.meta_desc')" type="website">
        <script type="application/ld+json">
        {!! json_encode([
            '@@context' => 'https://schema.org',
            '@type' => 'WebSite',
            'name' => 'EU VAT Info',
            'url' => url('/'),
            'description' => 'VAT rates and calculator for all EU countries',
            'potentialAction' => [
                '@type' => 'SearchAction',
                'target' => ['@type' => 'EntryPoint', 'urlTemplate' => url('/').'?search={search_term_string}'],
                'query-input' => 'required name=search_term_string',
            ],
        ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG) !!}
        </script>
        <script type="application/ld+json">
        {!! json_encode([
            '@@context' => 'https://schema.org',
            '@type' => 'Organization',
            'name' => 'EU VAT Info',
            'url' => url('/'),
            'description' => 'Comprehensive EU VAT rate information, calculators, and compliance tools for all 27 EU member states.',
        ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG) !!}
        </script>
        <script type="application/ld+json">
        {!! json_encode([
            '@@context' => 'https://schema.org',
            '@type' => 'Dataset',
            'name' => 'EU VAT Rates '.date('Y'),
            'description' => 'Current Value Added Tax (VAT) rates for all 27 EU member states, including standard, reduced, super-reduced, and parking rates.',
            'url' => url('/'),
            'license' => 'https://creativecommons.org/licenses/by/4.0/',
            'isAccessibleForFree' => true,
            'creator' => ['@type' => 'Organization', 'name' => 'EU VAT Info'],
            'distribution' => [
                ['@type' => 'DataDownload', 'encodingFormat' => 'application/json', 'contentUrl' => url('/api/countries')],
                ['@type' => 'DataDownload', 'encodingFormat' => 'text/plain', 'contentUrl' => url('/llms-full.txt')],
            ],
            'temporalCoverage' => '2000/'.date('Y'),
            'spatialCoverage' => ['@type' => 'Place', 'name' => 'European Union'],
        ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG) !!}
        </script>
    </x-seo-meta>
@endsection

@push('head')
    <link rel="amphtml" href="{{ url('/amp') }}">
@endpush

<div>
    <section class="hero-canvas" aria-labelledby="home-heading">
        <x-hero-backdrop />
        <div class="app-container relative pb-12 pt-10 sm:pb-16 sm:pt-14">
            <div class="mx-auto mb-8 max-w-3xl text-center sm:mb-10">
                <p class="inline-flex items-center gap-2 rounded-full border border-white/15 bg-white/10 px-3 py-1 text-xs font-semibold text-white/85">
                    <span class="size-1.5 rounded-full bg-gold" aria-hidden="true"></span>
                    {{ __('ui.home_page.hero_badge', ['year' => date('Y'), 'count' => $stats['count'] ?? 27]) }}
                </p>
                <h1 id="home-heading" class="mt-5 text-4xl font-bold tracking-[-0.035em] text-white sm:text-5xl sm:leading-[1.08]">
                    {{ __('ui.home_page.heading') }}
                    <span class="text-sky-200">{{ __('ui.home_page.heading_accent') }}</span>
                </h1>
                <p class="mx-auto mt-4 max-w-[62ch] text-base leading-7 text-white/80 sm:text-lg">
                    {{ __('ui.home_page.subtitle') }}
                </p>
            </div>

            <livewire:hero-calculator surface="dark" />
        </div>
    </section>

    <section class="app-container py-12 sm:py-16" aria-labelledby="rates-heading">
        <div class="grid grid-cols-1 items-start gap-8 lg:grid-cols-[minmax(0,1fr)_22rem]">
            <x-country-rates-table :countries="$countries" :search="$search" :stats="$stats" />
            <x-home-sidebar />
        </div>
    </section>
</div>
