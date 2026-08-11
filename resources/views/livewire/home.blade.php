@section('seo')
    <x-seo-meta :title="__('ui.home_page.title')"
        :description="__('ui.home_page.meta_desc')"
        type="website">
        <script type="application/ld+json">
        {
            "@@context": "https://schema.org",
            "@type": "WebSite",
            "name": "EU VAT Info",
            "url": "{{ url('/') }}",
            "description": "VAT rates and calculator for all EU countries",
            "potentialAction": {
                "@type": "SearchAction",
                "target": {
                    "@type": "EntryPoint",
                    "urlTemplate": "{{ url('/') }}?search={search_term_string}"
                },
                "query-input": "required name=search_term_string"
            }
        }
        </script>
        <script type="application/ld+json">
        {
            "@@context": "https://schema.org",
            "@type": "Organization",
            "name": "EU VAT Info",
            "url": "{{ url('/') }}",
            "description": "Comprehensive EU VAT rate information, calculators, and compliance tools for all 27 EU member states."
        }
        </script>
        <script type="application/ld+json">
        {
            "@@context": "https://schema.org",
            "@type": "Dataset",
            "name": "EU VAT Rates {{ date('Y') }}",
            "description": "Current Value Added Tax (VAT) rates for all 27 EU member states, including standard, reduced, super-reduced, and parking rates.",
            "url": "{{ url('/') }}",
            "license": "https://creativecommons.org/licenses/by/4.0/",
            "isAccessibleForFree": true,
            "creator": {
                "@type": "Organization",
                "name": "EU VAT Info"
            },
            "distribution": [
                {
                    "@type": "DataDownload",
                    "encodingFormat": "application/json",
                    "contentUrl": "{{ url('/api/countries') }}"
                },
                {
                    "@type": "DataDownload",
                    "encodingFormat": "text/plain",
                    "contentUrl": "{{ url('/llms-full.txt') }}"
                }
            ],
            "temporalCoverage": "2000/{{ date('Y') }}",
            "spatialCoverage": {
                "@type": "Place",
                "name": "European Union"
            }
        }
        </script>
    </x-seo-meta>
@endsection

@push('head')
    <link rel="amphtml" href="{{ url('/amp') }}">
    <link rel="preload" as="image" href="/images/eu-vat-calculator-background.jpg" fetchpriority="high">
@endpush

<div class="bg-workspace">
    <section class="relative overflow-hidden bg-brand" aria-labelledby="home-heading">
        <img
            src="/images/eu-vat-calculator-background.jpg"
            alt=""
            aria-hidden="true"
            class="absolute inset-0 h-full w-full object-cover object-center opacity-20"
            loading="eager"
            fetchpriority="high"
            decoding="async"
            width="2000"
            height="1116"
        >
        <div class="absolute inset-0 bg-[#102a43]/80"></div>

        <div class="relative mx-auto max-w-6xl px-4 py-10 sm:px-6 sm:py-14 lg:py-16">
            <div class="mx-auto mb-7 max-w-3xl text-center sm:mb-8">
                <h1 id="home-heading" class="mb-3 text-3xl font-bold leading-tight tracking-[-0.03em] text-white sm:text-4xl">
                    {{ __('ui.home_page.heading') }}
                    <span class="text-blue-200">{{ __('ui.home_page.heading_accent') }}</span>
                </h1>
                <p class="mx-auto max-w-[68ch] text-base leading-7 text-blue-50 sm:text-lg">
                    {{ __('ui.home_page.subtitle') }}
                </p>
            </div>

            <livewire:hero-calculator :show-header="false" />
        </div>
    </section>

    <section class="mx-auto max-w-6xl px-4 py-10 sm:px-6 sm:py-14" aria-label="EU VAT reference data">
        <div class="grid grid-cols-1 items-start gap-8 lg:grid-cols-12">
            <div class="lg:col-span-8">
                <x-country-rates-table :countries="$euCountries" :search="$search" />
            </div>

            <div class="lg:col-span-4">
                <x-home-sidebar />
            </div>
        </div>
    </section>
</div>
