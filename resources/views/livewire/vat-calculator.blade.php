@isset($selectedCountryObject)
    @section('title', 'VAT Calculator - ' . $selectedCountryObject->name)
@section('meta_description',
    'Calculate VAT amount for ' .
    $selectedCountryObject->name .
    '. Use our VAT
    calculator to easily calculate VAT for transactions in ' .
    $selectedCountryObject->name .
    '.')
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
@section('title', 'VAT Calculator - EU-VAT.info')
@section('meta_description',
    'Calculate VAT amount for different countries. Use our VAT
    calculator to easily calculate VAT for transactions in different countries.')
@section('seo')
    <x-seo-meta title="VAT Calculator - EU Countries | EU VAT Info"
        description="Calculate VAT for all EU countries. Free online calculator with current rates, historical data, and comparison tools." />
@endsection
@endisset

<div class="container py-12 mt-12 pb-12">
    @isset($selectedCountryObject)
        <x-breadcrumbs :items="['VAT Calculator' => '/vat-calculator', $selectedCountryObject->name => '']" />
    @else
        <x-breadcrumbs :items="['VAT Calculator' => '']" />
    @endisset

<div class="mb-6 mt-6  mx-auto">
    <h1 class="text-4xl sm:text-5xl font-extrabold text-gray-900 tracking-tight mb-6">
        @isset($selectedCountryObject)
            {{ $selectedCountryObject->name }} <span class="text-blue-600">VAT Calculator</span>
        @else
            European <span class="text-blue-600">VAT Calculator</span>
        @endisset
    </h1>
    
    @isset($selectedCountryObject)
        <p class="text-lg text-gray-600 leading-relaxed">
            Calculate VAT for transactions in {{ $selectedCountryObject->name }} easily. 
            Current standard rate is <span class="font-bold text-gray-900">{{ $selectedCountryObject->standard_rate }}%</span>.
        </p>
    @else
        <p class="text-lg text-gray-600 leading-relaxed">
            Quickly calculate VAT amounts for any of the 27 European Union member states.
        </p>
    @endisset
</div>

<!-- Main Grid Container -->
<div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-start">
    <!-- Calculator Form (Prominent) -->
    <div class="lg:col-span-7 order-1">
        <livewire:vat-calculator-form :slug="$selectedCountryObject->slug ?? null" />
    </div>

    <!-- Sidebar / Info -->
    <div class="lg:col-span-5 order-2 space-y-6">
        @isset($selectedCountryObject)
            <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Current VAT Rates</h3>
                <x-country-rates :country="$selectedCountryObject" />
            </div>
        @endisset

        <livewire:vat-rate-history-chart :country="$selectedCountryObject" />

        @isset($selectedCountryObject)
        <div class="bg-blue-50 p-6 rounded-xl border border-blue-100">
            <h4 class="font-bold text-blue-900 mb-2">Need more details?</h4>
            <p class="text-sm text-blue-700 mb-4">
                Learn everything about VAT compliance, registration, and exceptions in {{ $selectedCountryObject->name }}.
            </p>
            <a wire:navigate href="{{ route('country.show', $selectedCountryObject->slug) }}" class="text-sm font-bold text-blue-600 hover:text-blue-800 hover:underline">
                View {{ $selectedCountryObject->name }} VAT Guide &rarr;
            </a>
        </div>
        @endisset
    </div>
</div>

<div class="mt-16 grid grid-cols-1 gap-8">
    <!-- Map Section -->
    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
        <livewire:europe-map :activeCountry="$selectedCountryObject" />
    </div>

    <!-- Saved Searches & Links -->
    <div>
        <x-saved-searches></x-saved-searches>
    </div>

    <div class="pb-12">
        <x-country-calculator-list></x-country-calculator-list>
    </div>
</div>
</div>
