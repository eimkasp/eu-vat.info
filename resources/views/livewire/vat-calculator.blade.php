@isset($selectedCountryObject)
    @section('title', __('ui.calculator.meta_title_country', ['country' => $selectedCountryObject->name]))
@section('meta_description', __('ui.calculator.meta_desc_country', ['country' => $selectedCountryObject->name]))
@section('seo')
    <x-seo-meta :title="'VAT Calculator - ' . $selectedCountryObject->name . ' | EU VAT Info'" :description="'Calculate VAT for ' .
        $selectedCountryObject->name .
        '. Standard rate: ' .
        $selectedCountryObject->standard_rate .
        '%. Historical data from 2000. Free calculator with real-time rates.'" :url="route('vat-calculator.country', $selectedCountryObject->slug)">
        <!-- Schema.org JSON-LD -->
        <script type="application/ld+json">
             {
                 "@context": "https://schema.org",
                 "@type": "WebApplication",
                 "name": "{{ $selectedCountryObject->name }} VAT Calculator",
                 "description": "Calculate VAT for {{ $selectedCountryObject->name }}. Standard rate: {{ $selectedCountryObject->standard_rate }}%",
                 "url": "{{ route('vat-calculator.country', $selectedCountryObject->slug) }}",
                 "applicationCategory": "FinanceApplication",
                 "operatingSystem": "Web",
                 "offers": {
                     "@type": "Offer",
                     "price": "0",
                     "priceCurrency": "USD"
                 },
                 "provider": {
                     "@type": "Organization",
                     "name": "EU VAT Info",
                     "url": "{{ url('/') }}"
                 },
                 "about": {
                     "@type": "GovernmentService",
                     "name": "{{ $selectedCountryObject->name }} VAT",
                     "serviceType": "Value Added Tax",
                     "areaServed": {
                         "@type": "Country",
                         "name": "{{ $selectedCountryObject->name }}"
                     }
                 }
             }
             </script>
    </x-seo-meta>
@endsection
@else
@section('title', __('ui.calculator.meta_title_generic'))
@section('meta_description', __('ui.calculator.meta_desc_generic'))
@section('seo')
    <x-seo-meta title="VAT Calculator - EU Countries | EU VAT Info"
        description="Calculate VAT for all EU countries. Free online calculator with current rates, historical data, and comparison tools." />
@endsection
@endisset

<div class="min-h-screen">
    {{-- Hero section with background image + calculator --}}
    <div class="relative pt-8 pb-12">
        {{-- Background image --}}
        <div class="absolute inset-0 z-0">
            @isset($selectedCountryObject)
                {{-- Per-country image when available, fallback to default --}}
                @if(file_exists(public_path('images/countries/' . strtolower($selectedCountryObject->iso_code) . '.jpg')))
                    <img src="/images/countries/{{ strtolower($selectedCountryObject->iso_code) }}.jpg" alt="" class="w-full h-full object-cover" loading="eager">
                @else
                    <img src="/images/eu-vat-calculator-background.jpg" alt="" class="w-full h-full object-cover" loading="eager">
                @endif
            @else
                <img src="/images/eu-vat-calculator-background.jpg" alt="" class="w-full h-full object-cover" loading="eager">
            @endisset
            <div class="absolute inset-0 bg-gradient-to-b from-white/60 via-white/80 to-white"></div>
        </div>

        <div class="container relative">
            @isset($selectedCountryObject)
                <x-breadcrumbs :items="[__('ui.calculator.breadcrumb_label') => locale_path('/vat-calculator'), $selectedCountryObject->name => '']" />
            @else
                <x-breadcrumbs :items="[__('ui.calculator.breadcrumb_label') => '']" />
            @endisset

            {{-- Page heading --}}
            <div class="text-center mt-6 mb-8">
                <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold tracking-tight mb-3">
                    @isset($selectedCountryObject)
                        <div class="flex items-center justify-center gap-3 mb-2">
                            <img src="https://flagcdn.com/h80/{{ strtolower($selectedCountryObject->iso_code) }}.jpg"
                                 alt="{{ $selectedCountryObject->name }} flag"
                                 class="h-8 sm:h-10 w-auto rounded shadow-sm">
                            <span class="text-gray-900">{{ $selectedCountryObject->name }}</span>
                        </div>
                        <span class="text-blue-600">{{ __('ui.calculator.title') }}</span>
                    @else
                        <span class="text-blue-600">EU VAT</span> <span class="text-gray-900">{{ __('ui.calculator.title') }}</span>
                    @endisset
                </h1>
                <p class="text-base sm:text-lg text-gray-500 max-w-2xl mx-auto leading-relaxed">
                    @isset($selectedCountryObject)
                        {{ __('ui.calculator.country_subtitle', ['country' => $selectedCountryObject->name, 'rate' => $selectedCountryObject->standard_rate]) }}
                    @else
                        {{ __('ui.calculator.generic_subtitle') }}
                    @endisset
                </p>
            </div>

            {{-- Calculator Widget (no built-in header) --}}
            <livewire:hero-calculator :initial-country="$selectedCountryObject?->slug" :show-header="false" />
        </div>
    </div>

    {{-- Content section --}}
    <div class="container relative py-12">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-start">
            {{-- Main content --}}
            <div class="lg:col-span-7 space-y-8">
                @isset($selectedCountryObject)
                    {{-- Country VAT rates card --}}
                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                        <h2 class="text-xl font-bold text-gray-900 mb-4 flex items-center gap-2">
                            <img src="https://flagcdn.com/h40/{{ strtolower($selectedCountryObject->iso_code) }}.jpg"
                                 alt="" class="h-5 w-auto rounded-sm shadow-sm">
                            {{ __('ui.calculator.current_vat_rates') }}
                        </h2>
                        <x-country-rates :country="$selectedCountryObject" />
                    </div>
                @endisset

                {{-- Rate history chart --}}
                {{-- <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                    <livewire:vat-rate-history-chart :country="$selectedCountryObject" />
                </div> --}}

                {{-- Map --}}
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                    <livewire:europe-map :activeCountry="$selectedCountryObject" />
                </div>
            </div>

            {{-- Sidebar --}}
            <div class="lg:col-span-5 space-y-6">
                @isset($selectedCountryObject)
                    <div class="bg-blue-50 p-6 rounded-2xl border border-blue-100">
                        <h3 class="font-bold text-blue-900 mb-2">{{ __('ui.calculator.need_more_details') }}</h3>
                        <p class="text-sm text-blue-700 mb-4">
                            {{ __('ui.calculator.need_more_details_desc', ['country' => $selectedCountryObject->name]) }}
                        </p>
                        <a href="{{ route('country.show', $selectedCountryObject->slug) }}" wire:navigate
                           class="inline-flex items-center gap-1.5 text-sm font-bold text-blue-600 hover:text-blue-800 hover:underline">
                            {{ __('ui.calculator.view_vat_guide', ['country' => $selectedCountryObject->name]) }}
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                            </svg>
                        </a>
                    </div>
                @endisset

                {{-- Saved searches --}}
                <x-saved-searches />

                {{-- All country calculators --}}
                <x-country-calculator-list />
            </div>
        </div>
    </div>
</div>
