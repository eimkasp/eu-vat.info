<div class="container">
    @section('title', __('ui.calculator.title') . ' ' . $country->name . ' — ' . $country->standard_rate . '% VAT')
    @section('meta_description', 'Complete VAT guide for ' . $country->name . '. Standard rate: ' . $country->standard_rate . '%. Free VAT calculator, all rates, compliance info.')

    @push('head')
        <link rel="canonical" href="{{ route('country.show', $country->slug) }}">
        <meta property="og:title" content="{{ $country->name }} VAT Rates & Calculator — {{ $country->standard_rate }}%">
        <meta property="og:description" content="Complete VAT guide for {{ $country->name }}. Standard rate: {{ $country->standard_rate }}%. Free VAT calculator, all rates, compliance info.">
        <meta property="og:url" content="{{ route('country.show', $country->slug) }}">
        <meta property="og:type" content="website">
        <meta name="twitter:card" content="summary">
        <meta name="twitter:title" content="{{ $country->name }} VAT Rates & Calculator — {{ $country->standard_rate }}%">
        <meta name="twitter:description" content="Complete VAT guide for {{ $country->name }}. Standard rate: {{ $country->standard_rate }}%. Free VAT calculator, all rates, compliance info.">

        <x-country.json-ld :country="$country" />
    @endpush

    <div class="relative w-full">
        <div class="grid sm:grid-cols-12 gap-6 lg:gap-8">
            <!-- Sidebar -->
            <div class="sm:col-span-4 sm:sticky top-[-1px] sticky-element" style="align-self: flex-start">
                <x-country.sidebar :country="$country" />
            </div>

            <!-- Main Content -->
            <div class="sm:col-span-8 pb-12">
                <x-breadcrumbs :items="[$country->name => '']" />

                <!-- Hero Header -->
                <div class="mb-6">
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white">
                        {{ $country->name }} VAT Rates & Calculator
                    </h1>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                        Complete guide to Value Added Tax in {{ $country->name }}. Current rates, free calculator, and compliance information.
                    </p>
                </div>

                {{-- ─── Section 1: VAT Calculator ─── --}}
                <section class="mb-8" id="calculator">
                    <livewire:vat-calculator-simple :country="$country" :key="'calc-'.$country->id" />

                    {{-- Quick formula reference --}}
                    <div class="grid md:grid-cols-2 gap-3 mt-4">
                        <div class="bg-white dark:bg-gray-800 p-4 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
                            <h3 class="text-sm font-bold mb-2 text-gray-900 dark:text-white">Adding {{ $country->standard_rate }}% VAT</h3>
                            <div class="bg-gray-50 dark:bg-gray-900 p-3 rounded-lg font-mono text-sm text-gray-800 dark:text-gray-200 border border-gray-200 dark:border-gray-700 mb-2">
                                Gross = Net &times; {{ 1 + $country->standard_rate / 100 }}
                            </div>
                            <div class="text-sm text-gray-500 dark:text-gray-400">
                                <strong>Example:</strong> {{ $country->currency_display }}100 net &rarr; <strong>{{ $country->currency_display }}{{ number_format(100 * (1 + $country->standard_rate / 100), 2) }}</strong> gross
                            </div>
                        </div>
                        <div class="bg-white dark:bg-gray-800 p-4 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
                            <h3 class="text-sm font-bold mb-2 text-gray-900 dark:text-white">Removing {{ $country->standard_rate }}% VAT</h3>
                            <div class="bg-gray-50 dark:bg-gray-900 p-3 rounded-lg font-mono text-sm text-gray-800 dark:text-gray-200 border border-gray-200 dark:border-gray-700 mb-2">
                                Net = Gross &divide; {{ 1 + $country->standard_rate / 100 }}
                            </div>
                            <div class="text-sm text-gray-500 dark:text-gray-400">
                                <strong>Example:</strong> {{ $country->currency_display }}100 gross &rarr; <strong>{{ $country->currency_display }}{{ number_format(100 / (1 + $country->standard_rate / 100), 2) }}</strong> net
                            </div>
                        </div>
                    </div>
                </section>

                {{-- ─── Section 3: Key Information ─── --}}
                <section class="mb-8" id="info">
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Key Information
                    </h2>

                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 divide-y divide-gray-100 dark:divide-gray-700">
                        <div class="grid grid-cols-2 sm:grid-cols-3 gap-px">
                            <div class="p-4">
                                <dt class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Country Code</dt>
                                <dd class="mt-1 text-lg font-semibold text-gray-900 dark:text-white">{{ $country->iso_code }}</dd>
                            </div>
                            <div class="p-4">
                                <dt class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Currency</dt>
                                <dd class="mt-1 text-lg font-semibold text-gray-900 dark:text-white">{{ $country->currency_display }}</dd>
                            </div>
                            <div class="p-4">
                                <dt class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Standard Rate</dt>
                                <dd class="mt-1 text-lg font-semibold text-gray-900 dark:text-white">{{ $country->standard_rate }}%</dd>
                            </div>
                            <div class="p-4">
                                <dt class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">VAT Number Format</dt>
                                <dd class="mt-1 text-lg font-semibold text-gray-900 dark:text-white">{{ $country->iso_code }}XXXXXXXXX</dd>
                            </div>
                            <div class="p-4">
                                <dt class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">EU Member</dt>
                                <dd class="mt-1 text-lg font-semibold text-green-600 dark:text-green-400">Yes</dd>
                            </div>
                            <div class="p-4">
                                <dt class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">VIES Validation</dt>
                                <dd class="mt-1 text-lg font-semibold text-green-600 dark:text-green-400">Available</dd>
                            </div>
                        </div>
                    </div>
                </section>

                {{-- ─── Section 4: VAT Guide ─── --}}
                <section class="mb-8" id="guide">
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                        {{ $country->name }} VAT Guide
                    </h2>

                    <div class="prose prose-blue prose-lg max-w-none dark:prose-invert">
                        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6 mb-6">
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white mt-0 mb-3">VAT Registration & Compliance</h3>
                            <p class="text-gray-600 dark:text-gray-400 leading-relaxed mb-0">
                                Businesses operating in {{ $country->name }} must register for VAT if their annual turnover exceeds the national threshold. 
                                Foreign companies trading in {{ $country->name }} may need to register immediately without a threshold.
                                The standard VAT rate of <strong class="text-blue-600 dark:text-blue-400">{{ $country->standard_rate }}%</strong> applies to most goods and services.
                            </p>
                        </div>

                        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white mt-0 mb-3">Rate Structure</h3>
                            <p class="text-gray-600 dark:text-gray-400 leading-relaxed">
                                {{ $country->name }} applies different VAT rates depending on the product or service:
                            </p>
                            <ul class="text-gray-600 dark:text-gray-400 space-y-1">
                                <li><strong>Standard Rate ({{ $country->standard_rate }}%)</strong> — applies to most goods and services</li>
                                @if($country->reduced_rate)
                                    <li><strong>Reduced Rate ({{ $country->reduced_rate }}%)</strong> — applies to essential goods like food, books, and pharmaceuticals</li>
                                @endif
                                @if($country->super_reduced_rate)
                                    <li><strong>Super Reduced Rate ({{ $country->super_reduced_rate }}%)</strong> — applies to basic necessities</li>
                                @endif
                                @if($country->parking_rate)
                                    <li><strong>Parking Rate ({{ $country->parking_rate }}%)</strong> — transitional rate for specific goods</li>
                                @endif
                            </ul>
                        </div>
                    </div>
                </section>

                {{-- ─── Section 5: FAQ ─── --}}
                <section class="mb-8" id="faq">
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Frequently Asked Questions
                    </h2>

                    <div class="space-y-4" x-data="{ open: null }">
                        @php
                            $cs = $country->currency_display;
                            $faqs = [
                                [
                                    'q' => "What is the current VAT rate in {$country->name}?",
                                    'a' => "The standard VAT rate in {$country->name} is {$country->standard_rate}%." . ($country->reduced_rate ? " A reduced rate of {$country->reduced_rate}% applies to certain essential goods and services." : ""),
                                ],
                                [
                                    'q' => "How do I add {$country->standard_rate}% VAT to a price?",
                                    'a' => "Multiply the net price by " . (1 + $country->standard_rate / 100) . ". For example, {$cs}100 × " . (1 + $country->standard_rate / 100) . " = {$cs}" . number_format(100 * (1 + $country->standard_rate / 100), 2) . " including VAT.",
                                ],
                                [
                                    'q' => "How do I remove VAT from a gross price in {$country->name}?",
                                    'a' => "Divide the gross price by " . (1 + $country->standard_rate / 100) . ". For example, {$cs}" . number_format(100 * (1 + $country->standard_rate / 100), 2) . " ÷ " . (1 + $country->standard_rate / 100) . " = {$cs}100.00 net.",
                                ],
                                [
                                    'q' => "What format do {$country->name} VAT numbers use?",
                                    'a' => "VAT numbers in {$country->name} start with the country code '{$country->iso_code}' followed by a series of digits. The format is {$country->iso_code}XXXXXXXXX.",
                                ],
                                [
                                    'q' => "Do I need to register for VAT in {$country->name}?",
                                    'a' => "If your business exceeds the national VAT registration threshold in {$country->name}, you must register. Foreign businesses selling goods or services in {$country->name} may need to register immediately.",
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
                        <a href="{{ route('vat-calculator.country', $country->slug) }}" wire:navigate
                           class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors text-sm font-medium">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                            Full VAT Calculator
                        </a>
                        <a href="{{ locale_path('/vat-changes') }}" wire:navigate
                           class="inline-flex items-center gap-2 px-4 py-2 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors text-sm font-medium">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            VAT Rate History
                        </a>
                        <a href="{{ locale_path('/vat-map') }}" wire:navigate
                           class="inline-flex items-center gap-2 px-4 py-2 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors text-sm font-medium">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"></path></svg>
                            EU VAT Map
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
            <a href="{{ locale_path('/sitemap') }}" wire:navigate class="text-blue-600 hover:text-blue-800 hover:underline text-sm font-medium">
                {{ __('ui.sitemap.country_pages') }} &rarr;
            </a>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const el = document.querySelector(".sticky-element");
            if (el) {
                const observer = new IntersectionObserver(
                    ([e]) => e.target.classList.toggle("is-pinned", e.intersectionRatio < 1),
                    { threshold: [1] }
                );
                observer.observe(el);
                el.addEventListener('click', () => el.classList.toggle('is-pinned'));
            }
        });
    </script>
</div>
