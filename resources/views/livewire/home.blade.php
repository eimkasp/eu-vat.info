@section('seo')
    <x-seo-meta :title="__('ui.home_page.title')"
        :description="__('ui.home_page.meta_desc')"
        type="website">
        <script type="application/ld+json">
        {
            "@context": "https://schema.org",
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
            "@context": "https://schema.org",
            "@type": "Organization",
            "name": "EU VAT Info",
            "url": "{{ url('/') }}",
            "description": "Comprehensive EU VAT rate information, calculators, and compliance tools for all 27 EU member states."
        }
        </script>
        <script type="application/ld+json">
        {
            "@context": "https://schema.org",
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

<div class="relative" x-data="{ showMap: true }">
    {{-- Full-screen Background Image --}}
    <div class="absolute inset-0 z-0">
        <img src="/images/eu-vat-calculator-background.jpg" alt="" class="w-full h-screen object-cover" loading="eager">
    </div>

    <div class="relative z-10 mx-auto max-w-7xl px-4 py-6 sm:py-12">
        {{-- Hero Calculator Widget --}}
        <div class="mb-12 sm:mb-16 py-6 sm:py-10">
            <livewire:hero-calculator />
        </div>

        {{-- Country Table + Sidebar --}}
        <div class="grid grid-cols-1 md:grid-cols-12 gap-12">
            <div class="md:col-span-7">
                <x-country-rates-table :countries="$euCountries" :search="$search" />
            </div>

            <div class="md:col-span-5">
                <x-home-sidebar />
            </div>
        </div>
    </div>
</div>
