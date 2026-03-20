<div class="container">
    @section('title', __('ui.country_page.seo_title', ['country' => $country->name, 'rate' => $country->standard_rate]))
    @section('meta_description', __('ui.country_page.seo_description', ['country' => $country->name, 'rate' => $country->standard_rate]))

    @push('head')
        <link rel="canonical" href="{{ route('country.show', $country->slug) }}">
        <meta property="og:title" content="{{ __('ui.country_page.seo_title', ['country' => $country->name, 'rate' => $country->standard_rate]) }}">
        <meta property="og:description" content="{{ __('ui.country_page.seo_description', ['country' => $country->name, 'rate' => $country->standard_rate]) }}">
        <meta property="og:url" content="{{ route('country.show', $country->slug) }}">
        <meta property="og:type" content="website">
        <meta name="twitter:card" content="summary">
        <meta name="twitter:title" content="{{ __('ui.country_page.seo_title', ['country' => $country->name, 'rate' => $country->standard_rate]) }}">
        <meta name="twitter:description" content="{{ __('ui.country_page.seo_description', ['country' => $country->name, 'rate' => $country->standard_rate]) }}">
        <meta property="article:modified_time" content="{{ $country->updated_at->toIso8601String() }}">
        <meta name="last-modified" content="{{ $country->updated_at->toIso8601String() }}">

        <x-country.json-ld :country="$country" />
    @endpush

    <div class="relative w-full">
        <div class="grid sm:grid-cols-12 gap-6 lg:gap-8">
            <!-- Sidebar -->
            <div class="sm:col-span-4">
                <x-country.sidebar :country="$country" />
            </div>

            <!-- Main Content -->
            <div class="sm:col-span-8 pb-12">
                <x-breadcrumbs :items="[__('ui.breadcrumbs.countries') => locale_path('/'), $country->name => '']" />

                <!-- Hero Header -->
                <div class="mb-6">
                    <h1 class="text-3xl font-bold text-gray-900 dark:text-white">
                        {{ __('ui.country_page.heading', ['country' => $country->name]) }}
                    </h1>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                        {{ __('ui.country_page.hero_subtitle', ['country' => $country->name]) }}
                    </p>
                </div>

                {{-- ─── Section 1: VAT Calculator ─── --}}
                <section class="mb-8" id="calculator">
                    <livewire:vat-calculator-simple :country="$country" :key="'calc-'.$country->id" />

                    {{-- Quick formula reference --}}
                    <div class="grid md:grid-cols-2 gap-3 mt-4">
                        <div class="bg-white dark:bg-gray-800 p-4 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
                            <h3 class="text-sm font-bold mb-2 text-gray-900 dark:text-white">{{ __('ui.country_page.adding_vat', ['rate' => $country->standard_rate]) }}</h3>
                            <div class="bg-gray-50 dark:bg-gray-900 p-3 rounded-lg font-mono text-sm text-gray-800 dark:text-gray-200 border border-gray-200 dark:border-gray-700 mb-2">
                                {{ __('ui.country_page.formula_gross') }} {{ 1 + $country->standard_rate / 100 }}
                            </div>
                            <div class="text-sm text-gray-500 dark:text-gray-400">
                                <strong>{{ __('ui.country_page.example') }}</strong> {{ $country->currency_display }}100 {{ __('ui.country_page.net') }} &rarr; <strong>{{ $country->currency_display }}{{ number_format(100 * (1 + $country->standard_rate / 100), 2) }}</strong> {{ __('ui.country_page.gross') }}
                            </div>
                        </div>
                        <div class="bg-white dark:bg-gray-800 p-4 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
                            <h3 class="text-sm font-bold mb-2 text-gray-900 dark:text-white">{{ __('ui.country_page.removing_vat', ['rate' => $country->standard_rate]) }}</h3>
                            <div class="bg-gray-50 dark:bg-gray-900 p-3 rounded-lg font-mono text-sm text-gray-800 dark:text-gray-200 border border-gray-200 dark:border-gray-700 mb-2">
                                {{ __('ui.country_page.formula_net') }} {{ 1 + $country->standard_rate / 100 }}
                            </div>
                            <div class="text-sm text-gray-500 dark:text-gray-400">
                                <strong>{{ __('ui.country_page.example') }}</strong> {{ $country->currency_display }}100 {{ __('ui.country_page.gross') }} &rarr; <strong>{{ $country->currency_display }}{{ number_format(100 / (1 + $country->standard_rate / 100), 2) }}</strong> {{ __('ui.country_page.net') }}
                            </div>
                        </div>
                    </div>
                </section>

                {{-- ─── Section 3: Key Information ─── --}}
                <section class="mb-8" id="info">
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        {{ __('ui.country_page.key_information') }}
                    </h2>

                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 divide-y divide-gray-100 dark:divide-gray-700">
                        <div class="grid grid-cols-2 sm:grid-cols-3 gap-px">
                            <div class="p-4">
                                <dt class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">{{ __('ui.country_page.country_code') }}</dt>
                                <dd class="mt-1 text-lg font-semibold text-gray-900 dark:text-white">{{ $country->iso_code }}</dd>
                            </div>
                            <div class="p-4">
                                <dt class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">{{ __('ui.country_page.currency') }}</dt>
                                <dd class="mt-1 text-lg font-semibold text-gray-900 dark:text-white">{{ $country->currency_display }}</dd>
                            </div>
                            <div class="p-4">
                                <dt class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">{{ __('ui.country_page.standard_rate_label') }}</dt>
                                <dd class="mt-1 text-lg font-semibold text-gray-900 dark:text-white">{{ $country->standard_rate }}%</dd>
                            </div>
                            <div class="p-4">
                                <dt class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">{{ __('ui.country_page.vat_number_format') }}</dt>
                                <dd class="mt-1 text-lg font-semibold text-gray-900 dark:text-white">{{ $country->iso_code }}XXXXXXXXX</dd>
                            </div>
                            <div class="p-4">
                                <dt class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">{{ __('ui.country_page.eu_member') }}</dt>
                                <dd class="mt-1 text-lg font-semibold text-green-600 dark:text-green-400">{{ __('ui.country_page.yes') }}</dd>
                            </div>
                            <div class="p-4">
                                <dt class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">{{ __('ui.country_page.vies_validation') }}</dt>
                                <dd class="mt-1 text-lg font-semibold text-green-600 dark:text-green-400">{{ __('ui.country_page.available') }}</dd>
                            </div>
                        </div>
                    </div>
                </section>

                {{-- ─── Section 4: VAT Guide ─── --}}
                <section class="mb-8" id="guide">
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                        {{ __('ui.country_page.vat_guide_heading', ['country' => $country->name]) }}
                    </h2>

                    <div class="prose prose-blue prose-lg max-w-none dark:prose-invert">
                        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6 mb-6">
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white mt-0 mb-3">{{ __('ui.country_page.vat_registration_heading') }}</h3>
                            <p class="text-gray-600 dark:text-gray-400 leading-relaxed mb-0">
                                {{ __('ui.country_page.vat_registration_text', ['country' => $country->name, 'rate' => $country->standard_rate]) }}
                            </p>
                        </div>

                        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white mt-0 mb-3">{{ __('ui.country_page.rate_structure_heading') }}</h3>
                            <p class="text-gray-600 dark:text-gray-400 leading-relaxed">
                                {{ __('ui.country_page.rate_structure_intro', ['country' => $country->name]) }}
                            </p>
                            <ul class="text-gray-600 dark:text-gray-400 space-y-1">
                                <li><strong>{{ __('ui.country_page.standard_rate_desc', ['rate' => $country->standard_rate]) }}</strong></li>
                                @if($country->reduced_rate)
                                    <li><strong>{{ __('ui.country_page.reduced_rate_desc', ['rate' => $country->reduced_rate]) }}</strong></li>
                                @endif
                                @if($country->super_reduced_rate)
                                    <li><strong>{{ __('ui.country_page.super_reduced_rate_desc', ['rate' => $country->super_reduced_rate]) }}</strong></li>
                                @endif
                                @if($country->parking_rate)
                                    <li><strong>{{ __('ui.country_page.parking_rate_desc', ['rate' => $country->parking_rate]) }}</strong></li>
                                @endif
                            </ul>
                        </div>
                    </div>
                </section>

                {{-- ─── Section 5: FAQ ─── --}}
                <section class="mb-8" id="faq">
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        {{ __('ui.country_page.faq_heading') }}
                    </h2>

                    <div class="space-y-4" x-data="{ open: null }">
                        @php
                            $cs = $country->currency_display;
                            $faqs = [
                                [
                                    'q' => __('ui.country_page.faq_q_current_rate', ['country' => $country->name]),
                                    'a' => __('ui.country_page.faq_a_current_rate', ['country' => $country->name, 'rate' => $country->standard_rate]) . ($country->reduced_rate ? ' ' . __('ui.country_page.reduced_rate_desc', ['rate' => $country->reduced_rate]) : ''),
                                ],
                                [
                                    'q' => __('ui.country_page.faq_q_add_vat', ['rate' => $country->standard_rate]),
                                    'a' => __('ui.country_page.faq_a_add_vat', ['rate' => $country->standard_rate, 'multiplier' => (1 + $country->standard_rate / 100), 'result' => number_format(100 * (1 + $country->standard_rate / 100), 2)]),
                                ],
                                [
                                    'q' => __('ui.country_page.faq_q_remove_vat', ['country' => $country->name]),
                                    'a' => __('ui.country_page.faq_a_remove_vat', ['divisor' => (1 + $country->standard_rate / 100), 'gross' => number_format(100 * (1 + $country->standard_rate / 100), 2)]),
                                ],
                                [
                                    'q' => __('ui.country_page.faq_q_vat_format', ['country' => $country->name]),
                                    'a' => __('ui.country_page.faq_a_vat_format', ['country' => $country->name, 'code' => $country->iso_code, 'format' => $country->iso_code . 'XXXXXXXXX']),
                                ],
                                [
                                    'q' => __('ui.country_page.faq_q_registration', ['country' => $country->name]),
                                    'a' => __('ui.country_page.faq_a_registration', ['country' => $country->name]),
                                ],
                            ];
                        @endphp

                        @foreach($faqs as $i => $faq)
                            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                                <button 
                                    @click="open = open === {{ $i }} ? null : {{ $i }}"
                                    class="w-full flex items-center justify-between px-5 py-4 text-left text-gray-900 dark:text-white font-medium hover:bg-gray-50 dark:hover:bg-gray-750 transition-colors">
                                    <span>{{ $faq['q'] }}</span>
                                    <svg class="w-5 h-5 flex-shrink-0 text-gray-500 transition-transform duration-200" :class="{ 'rotate-180': open === {{ $i }} }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </button>
                                <div x-show="open === {{ $i }}" x-collapse>
                                    <div class="px-5 pb-4 text-gray-600 dark:text-gray-400 text-sm leading-relaxed">
                                        {{ $faq['a'] }}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    {{-- FAQ Schema --}}
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

                {{-- ─── Section 6: Quick Links ─── --}}
                <section class="mb-6">
                    <div class="flex flex-wrap gap-3">
                        <a href="{{ route('vat-calculator.country', $country->slug) }}"
                           class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors text-sm font-medium">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                            {{ __('ui.country_page.full_calculator_link') }}
                        </a>
                        <a href="{{ locale_path('/vat-changes') }}"
                           class="inline-flex items-center gap-2 px-4 py-2 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors text-sm font-medium">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            {{ __('ui.country_page.rate_history_link') }}
                        </a>
                        <a href="{{ locale_path('/vat-map') }}"
                           class="inline-flex items-center gap-2 px-4 py-2 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors text-sm font-medium">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"></path></svg>
                            {{ __('ui.country_page.vat_map_link') }}
                        </a>
                    </div>
                </section>
            </div>
        </div>
    </div>

    <!-- Related Countries -->
    <div class="mt-9">
        <h3 class="text-xl font-bold mb-4">{{ __('ui.country_page.related') }}</h3>
        <x-related-countries :country="$country" />
        <div class="mt-6 text-center">
            <a href="{{ locale_path('/sitemap') }}" class="text-blue-600 hover:text-blue-800 hover:underline text-sm font-medium">
                {{ __('ui.sitemap.country_pages') }} &rarr;
            </a>
        </div>
    </div>

</div>
