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

@push('head')
    <link rel="preload" as="image" type="image/webp" imagesrcset="/images/eu-vat-calculator-background-sm.webp 640w, /images/eu-vat-calculator-background-md.webp 1280w, /images/eu-vat-calculator-background-lg.webp 2000w" imagesizes="100vw" fetchpriority="high">
@endpush

<div class="relative">
    {{-- Full-screen Background Image with Parallax --}}
    <div class="absolute inset-0 z-0 overflow-hidden">
        <div class="absolute inset-0 will-change-transform" style="transform: translateZ(0)"
             x-data="{ y: 0, motionOk: !window.matchMedia('(prefers-reduced-motion: reduce)').matches }"
             x-init="if (motionOk) window.addEventListener('scroll', () => { y = window.scrollY }, { passive: true })"
             :style="motionOk ? 'transform: translate3d(0, ' + (y * 0.4) + 'px, 0)' : ''"
        >
            <picture>
                <source
                    type="image/webp"
                    srcset="/images/eu-vat-calculator-background-sm.webp 640w,
                            /images/eu-vat-calculator-background-md.webp 1280w,
                            /images/eu-vat-calculator-background-lg.webp 2000w"
                    sizes="100vw"
                >
                <img
                    src="data:image/jpeg;base64,/9j/4AAQSkZJRgABAQAAAQABAAD/2wBDABsSFBcUERsXFhceHBsgKEIrKCUlKFE6PTBCYFVlZF9VXVtqeJmBanGQc1tdhbWGkJ6jq62rZ4C8ybqmx5moq6T/2wBDARweHigjKE4rK06kbl1upKSkpKSkpKSkpKSkpKSkpKSkpKSkpKSkpKSkpKSkpKSkpKSkpKSkpKSkpKSkpKSkpKT/wAARCAAWACgDAREAAhEBAxEB/8QAGAAAAwEBAAAAAAAAAAAAAAAAAAECAwX/xAAfEAACAQMFAQAAAAAAAAAAAAAAAgERExQDBBJBUTH/xAAXAQEBAQEAAAAAAAAAAAAAAAAAAQID/8QAFxEBAQEBAAAAAAAAAAAAAAAAABESAf/aAAwDAQACEQMRAD8A60qvp0rnENCFqRnxSey1ILKz2XSZKwo0ZTDNUw2T8pgDGYePlS1IqupTsimtwlXnHVx1M1qDHUUhY6eCkE7dRQLt1A//2Q=="
                    srcset="/images/eu-vat-calculator-background-sm.jpg 640w,
                            /images/eu-vat-calculator-background-md.jpg 1280w,
                            /images/eu-vat-calculator-background-lg.jpg 2000w"
                    sizes="100vw"
                    alt="EU VAT Calculator"
                    class="w-full h-[120vh] object-cover opacity-0 transition-opacity duration-700 ease-in"
                    onload="this.classList.remove('opacity-0')"
                    loading="eager"
                    fetchpriority="high"
                    decoding="async"
                    width="2000"
                    height="1116"
                >
            </picture>
        </div>
        <div class="absolute inset-0 bg-gradient-to-t from-black/85 via-black/70 to-black/50"></div>
    </div>

    <div class="relative z-10 mx-auto max-w-7xl px-4 py-6 sm:py-12">
        {{-- Hero Section: Headline + Calculator --}}
        <div class="mb-12 sm:mb-16 py-6 sm:py-10">
            <div class="text-center mb-6 sm:mb-8">
                <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold tracking-tight mb-3">
                    <span class="text-white [text-shadow:_0_2px_8px_rgba(0,0,0,0.4)]">{{ __('ui.home_page.heading') }}</span>
                    <span class="text-blue-300 [text-shadow:_0_2px_8px_rgba(0,0,0,0.4)]">{{ __('ui.home_page.heading_accent') }}</span>
                </h1>
                <p class="text-base sm:text-lg text-white/90 max-w-2xl mx-auto leading-relaxed [text-shadow:_0_1px_4px_rgba(0,0,0,0.3)]">
                    {{ __('ui.home_page.subtitle') }}
                </p>
            </div>
            <livewire:hero-calculator :show-header="false" />
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
