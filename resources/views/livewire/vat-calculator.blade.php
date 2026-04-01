@isset($selectedCountryObject)
@php
    $calcMetaTitle = __('ui.calculator.meta_title_country', ['country' => $selectedCountryObject->name, 'rate' => $selectedCountryObject->standard_rate]);
    $calcMetaDesc = __('ui.calculator.meta_desc_country', ['country' => $selectedCountryObject->name, 'rate' => $selectedCountryObject->standard_rate]);
    $calcCanonical = url(locale_path('/vat-calculator/' . $selectedCountryObject->slug));
@endphp
@section('title', $calcMetaTitle)
@section('meta_description', $calcMetaDesc)
@section('seo')
    <x-seo-meta :title="$calcMetaTitle"
        :description="$calcMetaDesc"
        :url="$calcCanonical">
        <link rel="canonical" href="{{ $calcCanonical }}">
        <meta property="og:url" content="{{ $calcCanonical }}">
        <meta property="og:type" content="website">
        <meta property="og:locale" content="{{ str_replace('-', '_', app()->getLocale()) }}">
        <meta property="article:modified_time" content="{{ $selectedCountryObject->updated_at->toIso8601String() }}">
        <script type="application/ld+json">
        {!! json_encode([
            '@context' => 'https://schema.org',
            '@type' => 'BreadcrumbList',
            'itemListElement' => [
                ['@type' => 'ListItem', 'position' => 1, 'name' => __('ui.calculator.schema_breadcrumb_home'), 'item' => url(locale_path('/'))],
                ['@type' => 'ListItem', 'position' => 2, 'name' => __('ui.calculator.schema_breadcrumb_calculator'), 'item' => url(locale_path('/vat-calculator'))],
                ['@type' => 'ListItem', 'position' => 3, 'name' => $selectedCountryObject->name, 'item' => $calcCanonical],
            ],
        ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
        </script>
        <script type="application/ld+json">
        {!! json_encode([
            '@context' => 'https://schema.org',
            '@type' => 'WebPage',
            '@id' => $calcCanonical . '#webpage',
            'name' => __('ui.calculator.schema_page_name', ['country' => $selectedCountryObject->name]),
            'description' => __('ui.calculator.schema_page_desc', ['country' => $selectedCountryObject->name, 'rate' => $selectedCountryObject->standard_rate]),
            'url' => $calcCanonical,
            'inLanguage' => app()->getLocale(),
            'isPartOf' => [
                '@type' => 'WebSite',
                '@id' => url(locale_path('/')) . '#website',
                'name' => __('ui.site_name'),
                'url' => url(locale_path('/')),
            ],
            'mainEntity' => [
                '@type' => 'WebApplication',
                '@id' => $calcCanonical . '#calculator',
                'name' => __('ui.calculator.schema_app_name', ['country' => $selectedCountryObject->name]),
                'applicationCategory' => 'FinanceApplication',
                'operatingSystem' => 'All',
                'offers' => ['@type' => 'Offer', 'price' => '0', 'priceCurrency' => 'EUR'],
                'featureList' => 'VAT calculation, Add VAT, Remove VAT, Multiple rate types',
                'about' => [
                    '@type' => 'Country',
                    'name' => $selectedCountryObject->name,
                ],
            ],
        ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
        </script>
    </x-seo-meta>
@endsection
@else
@section('title', __('ui.calculator.meta_title_generic'))
@section('meta_description', __('ui.calculator.meta_desc_generic'))
@section('seo')
    <x-seo-meta :title="__('ui.calculator.meta_title_generic')"
        :description="__('ui.calculator.meta_desc_generic')" />
@endsection
@endisset

<div class="min-h-screen">
    {{-- ─── Hero Section with Background Image + Calculator ─── --}}
    <div class="relative pt-4 pb-12">
        {{-- Background image --}}
        <div class="absolute inset-0 z-0">
            @isset($selectedCountryObject)
                @if(file_exists(public_path('images/countries/' . strtolower($selectedCountryObject->iso_code) . '.jpg')))
                    <img src="/images/countries/{{ strtolower($selectedCountryObject->iso_code) }}.jpg" alt="" class="w-full h-full object-cover" loading="eager">
                @else
                    <img src="/images/eu-vat-calculator-background.jpg" alt="" class="w-full h-full object-cover" loading="eager">
                @endif
            @else
                <img src="/images/eu-vat-calculator-background.jpg" alt="" class="w-full h-full object-cover" loading="eager">
            @endisset
            <div class="absolute inset-0 bg-gradient-to-b from-black/85 via-black/70 to-black/50"></div>
        </div>

        <div class="container relative">
            @isset($selectedCountryObject)
                <x-breadcrumbs variant="dark" :items="[__('ui.calculator.breadcrumb_label') => locale_path('/vat-calculator'), $selectedCountryObject->name => '']" />
            @else
                <x-breadcrumbs variant="dark" :items="[__('ui.calculator.breadcrumb_label') => '']" />
            @endisset

            {{-- Page heading --}}
            <div class="text-center mt-3 mb-6">
                <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold tracking-tight mb-3">
                    @isset($selectedCountryObject)
                        <div class="flex items-center justify-center gap-3 mb-2">
                            <img src="https://flagcdn.com/h80/{{ strtolower($selectedCountryObject->iso_code) }}.jpg"
                                 alt="{{ $selectedCountryObject->name }} flag"
                                 class="h-8 sm:h-10 w-auto rounded shadow-sm">
                            <span class="text-white [text-shadow:_0_2px_8px_rgba(0,0,0,0.4)]">{{ $selectedCountryObject->name }}</span>
                        </div>
                        <span class="text-blue-300 [text-shadow:_0_2px_8px_rgba(0,0,0,0.4)]">{{ __('ui.calculator.title') }}</span>
                    @else
                        <span class="text-blue-300 [text-shadow:_0_2px_8px_rgba(0,0,0,0.4)]">EU VAT</span>
                        <span class="text-white [text-shadow:_0_2px_8px_rgba(0,0,0,0.4)]">{{ __('ui.calculator.title') }}</span>
                    @endisset
                </h1>
                <p class="text-base sm:text-lg text-white/90 max-w-2xl mx-auto leading-relaxed [text-shadow:_0_1px_4px_rgba(0,0,0,0.3)]">
                    @isset($selectedCountryObject)
                        {{ __('ui.calculator.country_subtitle', ['country' => $selectedCountryObject->name, 'rate' => $selectedCountryObject->standard_rate]) }}
                    @else
                        {{ __('ui.calculator.generic_subtitle') }}
                    @endisset
                </p>
            </div>

            {{-- Calculator Widget --}}
            <livewire:hero-calculator :key="'hero-calc-' . ($selectedCountryObject?->id ?? 'default')" :initial-country="$selectedCountryObject?->slug" :show-header="false" />
        </div>
    </div>

    {{-- ─── Content Section ─── --}}
    <div class="container relative !py-12">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-start">

            {{-- ── Main content ── --}}
            <div class="lg:col-span-7 space-y-8">

                @isset($selectedCountryObject)
                    {{-- Quick Formula Reference --}}
                    <section id="calculator">
                        <div class="grid md:grid-cols-2 gap-3">
                            <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-200">
                                <h3 class="text-sm font-bold mb-2 text-gray-900">{{ __('ui.country_page.adding_vat', ['rate' => $selectedCountryObject->standard_rate]) }}</h3>
                                <div class="bg-gray-50 p-3 rounded-lg font-mono text-sm text-gray-800 border border-gray-200 mb-2">
                                    {{ __('ui.country_page.formula_gross') }} {{ 1 + $selectedCountryObject->standard_rate / 100 }}
                                </div>
                                <div class="text-sm text-gray-500">
                                    <strong>{{ __('ui.country_page.example') }}</strong> {{ $selectedCountryObject->currency_display }}100 {{ __('ui.country_page.net') }} &rarr;
                                    <strong>{{ $selectedCountryObject->currency_display }}{{ number_format(100 * (1 + $selectedCountryObject->standard_rate / 100), 2) }}</strong> {{ __('ui.country_page.gross') }}
                                </div>
                            </div>
                            <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-200">
                                <h3 class="text-sm font-bold mb-2 text-gray-900">{{ __('ui.country_page.removing_vat', ['rate' => $selectedCountryObject->standard_rate]) }}</h3>
                                <div class="bg-gray-50 p-3 rounded-lg font-mono text-sm text-gray-800 border border-gray-200 mb-2">
                                    {{ __('ui.country_page.formula_net') }} {{ 1 + $selectedCountryObject->standard_rate / 100 }}
                                </div>
                                <div class="text-sm text-gray-500">
                                    <strong>{{ __('ui.country_page.example') }}</strong> {{ $selectedCountryObject->currency_display }}100 {{ __('ui.country_page.gross') }} &rarr;
                                    <strong>{{ $selectedCountryObject->currency_display }}{{ number_format(100 / (1 + $selectedCountryObject->standard_rate / 100), 2) }}</strong> {{ __('ui.country_page.net') }}
                                </div>
                            </div>
                        </div>
                    </section>

                    {{-- Current VAT Rates --}}
                    <section id="rates">
                        <h2 class="text-xl font-bold text-gray-900 mb-4 flex items-center gap-2">
                            <img src="https://flagcdn.com/h40/{{ strtolower($selectedCountryObject->iso_code) }}.jpg" alt="" class="h-5 w-auto rounded-sm shadow-sm">
                            {{ __('ui.calculator.current_vat_rates') }}
                        </h2>
                        <x-country-rates :country="$selectedCountryObject" />
                    </section>

                    {{-- Key Information --}}
                    <section id="info">
                        <h2 class="text-xl font-bold text-gray-900 mb-4 flex items-center gap-2">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            {{ __('ui.country_page.key_information') }}
                        </h2>
                        <div class="bg-white rounded-xl shadow-sm border border-gray-200">
                            <div class="grid grid-cols-2 sm:grid-cols-3 gap-px">
                                <div class="p-4">
                                    <dt class="text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('ui.country_page.country_code') }}</dt>
                                    <dd class="mt-1 text-lg font-semibold text-gray-900">{{ $selectedCountryObject->iso_code }}</dd>
                                </div>
                                <div class="p-4">
                                    <dt class="text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('ui.country_page.currency') }}</dt>
                                    <dd class="mt-1 text-lg font-semibold text-gray-900">{{ $selectedCountryObject->currency_display }}</dd>
                                </div>
                                <div class="p-4">
                                    <dt class="text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('ui.country_page.standard_rate_label') }}</dt>
                                    <dd class="mt-1 text-lg font-semibold text-gray-900">{{ $selectedCountryObject->standard_rate }}%</dd>
                                </div>
                                <div class="p-4">
                                    <dt class="text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('ui.country_page.vat_number_format') }}</dt>
                                    <dd class="mt-1 text-lg font-semibold text-gray-900">{{ $selectedCountryObject->iso_code }}XXXXXXXXX</dd>
                                </div>
                                <div class="p-4">
                                    <dt class="text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('ui.country_page.eu_member') }}</dt>
                                    <dd class="mt-1 text-lg font-semibold text-green-600">{{ __('ui.country_page.yes') }}</dd>
                                </div>
                                <div class="p-4">
                                    <dt class="text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('ui.country_page.vies_validation') }}</dt>
                                    <dd class="mt-1 text-lg font-semibold text-green-600">{{ __('ui.country_page.available') }}</dd>
                                </div>
                            </div>
                        </div>
                    </section>

                    {{-- VAT Guide --}}
                    <section id="guide">
                        <h2 class="text-xl font-bold text-gray-900 mb-4 flex items-center gap-2">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                            {{ __('ui.country_page.vat_guide_heading', ['country' => $selectedCountryObject->name]) }}
                        </h2>
                        <div class="space-y-4">
                            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                                <h3 class="text-lg font-bold text-gray-900 mt-0 mb-3">{{ __('ui.country_page.vat_registration_heading') }}</h3>
                                <p class="text-gray-600 leading-relaxed mb-0">
                                    {{ __('ui.country_page.vat_registration_text', ['country' => $selectedCountryObject->name, 'rate' => $selectedCountryObject->standard_rate]) }}
                                </p>
                            </div>
                            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                                <h3 class="text-lg font-bold text-gray-900 mt-0 mb-3">{{ __('ui.country_page.rate_structure_heading') }}</h3>
                                <p class="text-gray-600 leading-relaxed">
                                    {{ __('ui.country_page.rate_structure_intro', ['country' => $selectedCountryObject->name]) }}
                                </p>
                                <ul class="text-gray-600 space-y-1 mt-2">
                                    <li><strong>{{ __('ui.country_page.standard_rate_desc', ['rate' => $selectedCountryObject->standard_rate]) }}</strong></li>
                                    @if($selectedCountryObject->reduced_rate)
                                        <li><strong>{{ __('ui.country_page.reduced_rate_desc', ['rate' => $selectedCountryObject->reduced_rate]) }}</strong></li>
                                    @endif
                                    @if($selectedCountryObject->super_reduced_rate)
                                        <li><strong>{{ __('ui.country_page.super_reduced_rate_desc', ['rate' => $selectedCountryObject->super_reduced_rate]) }}</strong></li>
                                    @endif
                                    @if($selectedCountryObject->parking_rate)
                                        <li><strong>{{ __('ui.country_page.parking_rate_desc', ['rate' => $selectedCountryObject->parking_rate]) }}</strong></li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </section>

                    {{-- FAQ --}}
                    <section id="faq">
                        <h2 class="text-xl font-bold text-gray-900 mb-4 flex items-center gap-2">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            {{ __('ui.country_page.faq_heading') }}
                        </h2>
                        <div class="space-y-3" x-data="{ open: null }">
                            @php
                                $faqs = [
                                    [
                                        'q' => __('ui.country_page.faq_q_current_rate', ['country' => $selectedCountryObject->name]),
                                        'a' => __('ui.country_page.faq_a_current_rate', ['country' => $selectedCountryObject->name, 'rate' => $selectedCountryObject->standard_rate]) . ($selectedCountryObject->reduced_rate ? ' ' . __('ui.country_page.reduced_rate_desc', ['rate' => $selectedCountryObject->reduced_rate]) : ''),
                                    ],
                                    [
                                        'q' => __('ui.country_page.faq_q_add_vat', ['rate' => $selectedCountryObject->standard_rate]),
                                        'a' => __('ui.country_page.faq_a_add_vat', ['rate' => $selectedCountryObject->standard_rate, 'multiplier' => (1 + $selectedCountryObject->standard_rate / 100), 'result' => number_format(100 * (1 + $selectedCountryObject->standard_rate / 100), 2)]),
                                    ],
                                    [
                                        'q' => __('ui.country_page.faq_q_remove_vat', ['country' => $selectedCountryObject->name]),
                                        'a' => __('ui.country_page.faq_a_remove_vat', ['divisor' => (1 + $selectedCountryObject->standard_rate / 100), 'gross' => number_format(100 * (1 + $selectedCountryObject->standard_rate / 100), 2)]),
                                    ],
                                    [
                                        'q' => __('ui.country_page.faq_q_vat_format', ['country' => $selectedCountryObject->name]),
                                        'a' => __('ui.country_page.faq_a_vat_format', ['country' => $selectedCountryObject->name, 'code' => $selectedCountryObject->iso_code, 'format' => $selectedCountryObject->iso_code . 'XXXXXXXXX']),
                                    ],
                                    [
                                        'q' => __('ui.country_page.faq_q_registration', ['country' => $selectedCountryObject->name]),
                                        'a' => __('ui.country_page.faq_a_registration', ['country' => $selectedCountryObject->name]),
                                    ],
                                ];
                            @endphp
                            @foreach($faqs as $i => $faq)
                                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                                    <button
                                        @click="open = open === {{ $i }} ? null : {{ $i }}"
                                        :aria-expanded="(open === {{ $i }}).toString()"
                                        aria-controls="faq-answer-{{ $i }}"
                                        class="w-full flex items-center justify-between px-5 py-4 text-left text-gray-900 font-medium hover:bg-gray-50 transition-colors">
                                        <span>{{ $faq['q'] }}</span>
                                        <svg class="w-5 h-5 flex-shrink-0 text-gray-500 transition-transform duration-200" :class="{ 'rotate-180': open === {{ $i }} }" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    </button>
                                    <div id="faq-answer-{{ $i }}" role="region" x-show="open === {{ $i }}" x-collapse>
                                        <div class="px-5 pb-4 text-gray-600 text-sm leading-relaxed">{{ $faq['a'] }}</div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        @push('head')
                        <script type="application/ld+json">
                        {!! json_encode([
                            '@context' => 'https://schema.org',
                            '@type' => 'FAQPage',
                            'mainEntity' => collect($faqs)->map(fn($f) => [
                                '@type' => 'Question',
                                'name' => $f['q'],
                                'acceptedAnswer' => ['@type' => 'Answer', 'text' => $f['a']],
                            ])->values()->all(),
                        ], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
                        </script>
                        @endpush
                    </section>

                    {{-- Quick links --}}
                    <section>
                        <div class="flex flex-wrap gap-3">
                            <a href="{{ locale_path('/vat-changes') }}"
                               class="inline-flex items-center gap-2 px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors text-sm font-medium">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                {{ __('ui.country_page.rate_history_link') }}
                            </a>
                            <a href="{{ locale_path('/vat-map') }}"
                               class="inline-flex items-center gap-2 px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors text-sm font-medium">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"></path></svg>
                                {{ __('ui.country_page.vat_map_link') }}
                            </a>
                        </div>
                    </section>
                @endisset

                {{-- Map --}}
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                    <livewire:europe-map :activeCountry="$selectedCountryObject" />
                </div>

                @isset($selectedCountryObject)
                    {{-- Related Countries --}}
                    <div class="pt-4 border-t border-gray-200">
                        <h3 class="text-xl font-bold mb-4">{{ __('ui.country_page.related') }}</h3>
                        <x-related-countries :country="$selectedCountryObject" />
                        <div class="mt-6 text-center">
                            <a href="{{ locale_path('/sitemap') }}" class="text-blue-600 hover:text-blue-800 hover:underline text-sm font-medium">
                                {{ __('ui.sitemap.country_pages') }} &rarr;
                            </a>
                        </div>
                    </div>
                @endisset
            </div>

            {{-- ── Sidebar ── --}}
            <div class="lg:col-span-5 space-y-6">
                @isset($selectedCountryObject)
                    <x-country.sidebar :country="$selectedCountryObject" />
                @endisset
                <x-saved-searches />
                <x-country-calculator-list />
            </div>
        </div>
    </div>
</div>
