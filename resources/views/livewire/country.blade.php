<div class="container" 
     x-data="{ activeTab: @entangle('activeTab') }"
     @update-url.window="history.pushState({}, '', $event.detail.url)">
    @section('title', $tabMeta['title'])
    @section('meta_description', $tabMeta['description'])
    
    @push('head')
        <!-- Canonical URL -->
        <link rel="canonical" href="{{ $tabMeta['url'] }}">
        
        <!-- Open Graph -->
        <meta property="og:title" content="{{ $tabMeta['title'] }}">
        <meta property="og:description" content="{{ $tabMeta['description'] }}">
        <meta property="og:url" content="{{ $tabMeta['url'] }}">
        <meta property="og:type" content="website">
        
        <!-- Twitter Card -->
        <meta name="twitter:card" content="summary">
        <meta name="twitter:title" content="{{ $tabMeta['title'] }}">
        <meta name="twitter:description" content="{{ $tabMeta['description'] }}">
        
        <!-- Structured Data -->
        <script type="application/ld+json">
        {
            "@context": "https://schema.org",
            "@type": "WebPage",
            "name": "{{ $tabMeta['title'] }}",
            "description": "{{ $tabMeta['description'] }}",
            "url": "{{ $tabMeta['url'] }}",
            "breadcrumb": {
                "@type": "BreadcrumbList",
                "itemListElement": [
                    {
                        "@type": "ListItem",
                        "position": 1,
                        "name": "Home",
                        "item": "{{ url('/') }}"
                    },
                    {
                        "@type": "ListItem",
                        "position": 2,
                        "name": "{{ $country->name }}",
                        "item": "{{ route('country.show', $country->slug) }}"
                    }
                    @if($activeTab !== 'overview')
                    ,{
                        "@type": "ListItem",
                        "position": 3,
                        "name": "{{ $tabMeta['name'] }}",
                        "item": "{{ $tabMeta['url'] }}"
                    }
                    @endif
                ]
            },
            "mainEntity": {
                "@type": "GovernmentService",
                "name": "{{ $country->name }} VAT Information",
                "description": "VAT rates and tools for {{ $country->name }}",
                "provider": {
                    "@type": "GovernmentOrganization",
                    "name": "{{ $country->name }} Tax Authority"
                },
                "areaServed": {
                    "@type": "Country",
                    "name": "{{ $country->name }}"
                },
                "serviceOutput": {
                    "@type": "TaxRate",
                    "name": "Standard VAT Rate",
                    "value": "{{ $country->standard_rate }}",
                    "unitText": "PERCENT"
                }
            }
        }
        </script>
        
        @if($activeTab === 'vat-calculator')
        <script type="application/ld+json">
        {
            "@context": "https://schema.org",
            "@type": "SoftwareApplication",
            "name": "{{ $country->name }} VAT Calculator",
            "applicationCategory": "FinanceApplication",
            "offers": {
                "@type": "Offer",
                "price": "0",
                "priceCurrency": "EUR"
            },
            "description": "Free online VAT calculator for {{ $country->name }}. Calculate {{ $country->standard_rate }}% VAT instantly.",
            "operatingSystem": "Web Browser",
            "url": "{{ route('country.tab', ['slug' => $country->slug, 'tab' => 'vat-calculator']) }}"
        }
        </script>
        @endif
    @endpush
        <div class="">
            <div class="relative w-full">
                <div class="grid sm:grid-cols-12 gap-9">
                    <div class="sm:col-span-12">
                        {{-- <x-country-rates :country="$country" /> --}}
                    </div>
                    <div class="sm:col-span-4 sm:sticky top-[-1px] sticky-element" style="align-self: flex-start">
                        <a href="/" class="mb-3 block flex items-center gap-3 hover:text-blue-700">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 inline-block" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 19l-7-7 7-7m8 14l-7-7 7-7"></path>
                            </svg>
                            Back to all countries
                        </a>
                        <x-country-stats :country="$country" />
                        <div class="mt-9 space-y-3 sm:mb-12 border-t pt-3">
                            <h4 class="font-bold text-gray-900 dark:text-white mb-3">VAT Tools</h4>

                            <div>
                                <a class="flex items-center gap-2 text-blue-600 hover:underline hover:text-blue-700 transition-colors" 
                                   wire:navigate
                                   href="{{ route('country.tab', ['slug' => $country->slug, 'tab' => 'vat-calculator']) }}">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                    </svg>
                                    VAT Calculator
                                </a>
                            </div>

                            <div>
                                <a class="flex items-center gap-2 text-blue-600 hover:underline hover:text-blue-700 transition-colors" 
                                   wire:navigate
                                   href="{{ route('country.tab', ['slug' => $country->slug, 'tab' => 'vat-validator']) }}">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    VAT Number Validator
                                    <span class="text-xs px-2 py-0.5 bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400 rounded-full">New</span>
                                </a>
                            </div>

                            <div>
                                <a class="flex items-center gap-2 text-blue-600 hover:underline hover:text-blue-700 transition-colors" 
                                   wire:navigate
                                   href="/embed/{{ $country->slug }}">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path>
                                    </svg>
                                    Embed VAT Widget
                                </a>
                            </div>
                        </div>
                        
                        <!-- Sidebar Banners -->
                        <x-banner-display position="country_sidebar" />
                    </div>

                    <div class="sm:col-span-8 pb-12">
                        <x-breadcrumbs :items="[$country->name => '']" />
                        
                        <div class="space-y-3">
                            <h1 class="text-2xl lg:text-3xl font-bold">
                                {{ $tabMeta['name'] }} - {{ $country->name }}
                            </h1>
                            <p class="text-gray-500 dark:text-gray-400">
                                {{ $tabMeta['description'] }}
                            </p>
                        </div>

                        <!-- Tab Navigation -->
                        <div class="my-6 border-b border-gray-200 dark:border-gray-700">
                            <nav class="-mb-px flex space-x-8 overflow-x-auto" aria-label="Tabs">
                                @foreach($tabs as $tabKey => $tab)
                                    <a href="{{ $tab['url'] }}" 
                                       wire:navigate
                                       @click.prevent="$wire.switchTab('{{ $tabKey }}')"
                                       class="
                                           flex items-center gap-2 py-4 px-1 border-b-2 font-medium text-sm whitespace-nowrap
                                           transition-colors duration-200
                                           {{ $activeTab === $tabKey 
                                               ? 'border-blue-500 text-blue-600 dark:text-blue-400' 
                                               : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300' 
                                           }}
                                       "
                                       :class="{ 'border-blue-500 text-blue-600 dark:text-blue-400': activeTab === '{{ $tabKey }}' }">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $tab['icon'] }}"></path>
                                        </svg>
                                        {{ $tab['name'] }}
                                    </a>
                                @endforeach
                            </nav>
                        </div>

                        <!-- Tab Content -->
                        <div class="tab-content">
                            <!-- Overview Tab -->
                            <div x-show="activeTab === 'overview'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 transform translate-y-4" x-transition:enter-end="opacity-100 transform translate-y-0">
                                @if($activeTab === 'overview')
                                    <div class="mb-6">
                                        <x-country-rates :country="$country" />
                                    </div>

                        {{-- <!-- VAT Validator Widget -->
                        <div class="mb-12">
                            <livewire:vat-validator :country="$country" />
                        </div> --}}

                        <div class="country-content max-w-3xl mx-auto">
                            <article class="prose prose-blue prose-lg max-w-none">
                                <h2 class="text-3xl font-bold text-gray-900 mb-6">{{ $country->name }} VAT Guide</h2>

                                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-8 mb-10">
                                    <h3 class="text-xl font-bold text-gray-900 mb-4">Introduction</h3>
                                    <p class="text-gray-600 leading-relaxed mb-0">
                                        {{ $country->name }}, as a member of the European Union, maintains its own unique VAT system. 
                                        The standard VAT rate is <span class="font-bold text-blue-600">{{ $country->standard_rate }}%</span>, 
                                        which applies to most goods and services. 
                                        Using our <a href="{{ route('vat-calculator.country', $country->slug) }}" class="text-blue-600 hover:underline font-medium">VAT Calculator</a>, 
                                        you can easily calculate the exact VAT amount for any transaction.
                                    </p>
                                </div>

                                <div class="space-y-10">
                                    <section>
                                        <h3 class="text-2xl font-bold text-gray-900 mb-4">VAT Rate Structure</h3>
                                        <p class="text-gray-600 mb-4">{{ $country->name }} applies different rates depending on the product or service:</p>
                                        
                                        <div class="grid sm:grid-cols-2 gap-4 not-prose">
                                            <div class="bg-blue-50 p-4 rounded-lg border border-blue-100">
                                                <div class="text-sm text-blue-600 font-semibold uppercase tracking-wide mb-1">Standard Rate</div>
                                                <div class="text-3xl font-bold text-gray-900">{{ $country->standard_rate }}%</div>
                                                <div class="text-sm text-gray-500 mt-1">Most goods & services</div>
                                            </div>
                                            @if($country->reduced_rate)
                                            <div class="bg-green-50 p-4 rounded-lg border border-green-100">
                                                <div class="text-sm text-green-600 font-semibold uppercase tracking-wide mb-1">Reduced Rate</div>
                                                <div class="text-3xl font-bold text-gray-900">{{ $country->reduced_rate }}%</div>
                                                <div class="text-sm text-gray-500 mt-1">Essentials (Food, Books, etc.)</div>
                                            </div>
                                            @endif
                                        </div>
                                    </section>

                                    <section>
                                        <h3 class="text-2xl font-bold text-gray-900 mb-4">VAT Registration & Compliance</h3>
                                        <p class="text-gray-600 leading-relaxed">
                                            Businesses operating in {{ $country->name }} must register for VAT if their annual turnover exceeds the national threshold. 
                                            Foreign companies trading in {{ $country->name }} may need to register immediately without a threshold.
                                        </p>
                                    </section>

                                    <section>
                                        <h3 class="text-2xl font-bold text-gray-900 mb-4">Tools & Resources</h3>
                                        <p class="text-gray-600 leading-relaxed">
                                            Use our specialized tools to manage your VAT obligations:
                                            <ul class="list-disc pl-5 space-y-2 mt-2">
                                                <li><a href="{{ route('vat-calculator.country', $country->slug) }}" class="text-blue-600 hover:underline">Calculate VAT for {{ $country->name }}</a></li>
                                                <li>Check valid VAT numbers via VIES (Coming Soon)</li>
                                                <li>View historical rate changes</li>
                                            </ul>
                                        </p>
                                    </section>
                                </div>
                            </article>
                        </div>

                        <!-- FAQ Section -->
                        <div class="mt-12 mb-8">
                            <h2 class="text-2xl font-bold mb-6">How to Calculate VAT in {{ $country->name }}</h2>
                            
                            <div class="space-y-6">
                                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
                                    <h3 class="text-lg font-bold mb-3 text-gray-900">Adding VAT to a Net Price</h3>
                                    <p class="text-gray-600 mb-4">To calculate the gross amount from a net price (excluding VAT), use the following formula:</p>
                                    <div class="bg-gray-50 p-4 rounded-lg font-mono text-sm text-gray-800 mb-4 border border-gray-200">
                                        Gross Amount = Net Price × (1 + VAT Rate / 100)
                                    </div>
                                    <div class="text-sm text-gray-600">
                                        <strong>Example:</strong> Calculating {{ $country->standard_rate }}% VAT on €100 net:<br>
                                        €100 × (1 + {{ $country->standard_rate / 100 }}) = €100 × {{ 1 + $country->standard_rate / 100 }} = <strong>€{{ 100 * (1 + $country->standard_rate / 100) }}</strong>
                                    </div>
                                </div>

                                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
                                    <h3 class="text-lg font-bold mb-3 text-gray-900">Removing VAT from a Gross Price</h3>
                                    <p class="text-gray-600 mb-4">To calculate the net price from a gross amount (including VAT), use this formula:</p>
                                    <div class="bg-gray-50 p-4 rounded-lg font-mono text-sm text-gray-800 mb-4 border border-gray-200">
                                        Net Price = Gross Amount ÷ (1 + VAT Rate / 100)
                                    </div>
                                    <div class="text-sm text-gray-600">
                                        <strong>Example:</strong> Extracting {{ $country->standard_rate }}% VAT from €100 gross:<br>
                                        €100 ÷ (1 + {{ $country->standard_rate / 100 }}) = €100 ÷ {{ 1 + $country->standard_rate / 100 }} = <strong>€{{ number_format(100 / (1 + $country->standard_rate / 100), 2) }}</strong>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <h3 class="text-xl font-medium">
                                {{ $country->name }} VAT Exceptions
                            </h3>
                                </div>
                            </div>
                        </div>
                                @endif
                            </div>

                            <!-- VAT Calculator Tab -->
                            <div x-show="activeTab === 'vat-calculator'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 transform translate-y-4" x-transition:enter-end="opacity-100 transform translate-y-0">
                                @if($activeTab === 'vat-calculator')
                                    <div class="space-y-6">
                                        <div class="bg-gradient-to-r from-blue-50 to-blue-100 dark:from-blue-900/20 dark:to-blue-800/20 p-6 rounded-xl border border-blue-200 dark:border-blue-800">
                                            <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-2">
                                                Calculate VAT for {{ $country->name }}
                                            </h2>
                                            <p class="text-gray-600 dark:text-gray-400 text-sm">
                                                Add or remove {{ $country->standard_rate }}% VAT from any amount instantly.
                                            </p>
                                        </div>

                                        <!-- Embed VAT Calculator Component -->
                                        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6">
                                            <livewire:vat-calculator-simple :country="$country" :key="'calc-'.$country->id" />
                                        </div>

                                        <!-- Calculator Instructions -->
                                        <div class="grid md:grid-cols-2 gap-6">
                                            <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
                                                <h3 class="text-lg font-bold mb-3 text-gray-900 dark:text-white">Adding VAT</h3>
                                                <p class="text-gray-600 dark:text-gray-400 mb-4 text-sm">Calculate the gross amount including VAT:</p>
                                                <div class="bg-gray-50 dark:bg-gray-900 p-4 rounded-lg font-mono text-sm text-gray-800 dark:text-gray-200 mb-4 border border-gray-200 dark:border-gray-700">
                                                    Gross = Net × (1 + {{ $country->standard_rate / 100 }})
                                                </div>
                                                <div class="text-sm text-gray-600 dark:text-gray-400">
                                                    <strong>Example:</strong> €100 net → €{{ 100 * (1 + $country->standard_rate / 100) }} gross
                                                </div>
                                            </div>

                                            <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
                                                <h3 class="text-lg font-bold mb-3 text-gray-900 dark:text-white">Removing VAT</h3>
                                                <p class="text-gray-600 dark:text-gray-400 mb-4 text-sm">Calculate the net amount excluding VAT:</p>
                                                <div class="bg-gray-50 dark:bg-gray-900 p-4 rounded-lg font-mono text-sm text-gray-800 dark:text-gray-200 mb-4 border border-gray-200 dark:border-gray-700">
                                                    Net = Gross ÷ (1 + {{ $country->standard_rate / 100 }})
                                                </div>
                                                <div class="text-sm text-gray-600 dark:text-gray-400">
                                                    <strong>Example:</strong> €100 gross → €{{ number_format(100 / (1 + $country->standard_rate / 100), 2) }} net
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <!-- VAT Validator Tab -->
                            <div x-show="activeTab === 'vat-validator'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 transform translate-y-4" x-transition:enter-end="opacity-100 transform translate-y-0">
                                @if($activeTab === 'vat-validator')
                                    <div class="space-y-6">
                                        <div class="bg-gradient-to-r from-green-50 to-green-100 dark:from-green-900/20 dark:to-green-800/20 p-6 rounded-xl border border-green-200 dark:border-green-800">
                                            <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-2">
                                                Validate {{ $country->name }} VAT Numbers
                                            </h2>
                                            <p class="text-gray-600 dark:text-gray-400 text-sm">
                                                Verify VAT numbers using the official EU VIES system with intelligent company matching.
                                            </p>
                                        </div>

                                        <!-- Embed VAT Validator Component -->
                                        <livewire:vat-validation-widget :countryCode="$country->iso_code" :key="'validator-'.$country->id" />

                                        <!-- Validator Info -->
                                        <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
                                            <h3 class="text-lg font-bold mb-3 text-gray-900 dark:text-white">About VAT Number Validation</h3>
                                            <div class="space-y-3 text-sm text-gray-600 dark:text-gray-400">
                                                <p>
                                                    {{ $country->name }} VAT numbers follow the format: <strong class="text-gray-900 dark:text-white">{{ $country->iso_code }}XXXXXXXXX</strong>
                                                </p>
                                                <p>
                                                    Our validator uses the European Commission's VIES (VAT Information Exchange System) to verify that VAT numbers are registered and valid. Results include company name and registered address when available.
                                                </p>
                                                <ul class="list-disc pl-5 space-y-1">
                                                    <li>Real-time validation against EU databases</li>
                                                    <li>Fuzzy matching for company names and addresses</li>
                                                    <li>Results cached for 7 days for faster lookup</li>
                                                    <li>Handles variations in formatting and capitalization</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="hidden mt-9">s="mt-8 p-6 bg-gray-50 rounded-xl border border-gray-200">
                            <h3 class="text-lg font-bold mb-4 text-gray-900">Quick Facts about {{ $country->name }}</h3>
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                                <div>
                                    <div class="text-xs text-gray-500 uppercase tracking-wider mb-1">ISO Code</div>
                                    <div class="font-mono font-medium text-gray-900">{{ $country->iso_code }}</div>
                                </div>
                                <div>
                                    <div class="text-xs text-gray-500 uppercase tracking-wider mb-1">Currency</div>
                                    <div class="font-medium text-gray-900">{{ $country->currency_code ?? 'EUR' }}</div>
                                </div>
                                <div>
                                    <div class="text-xs text-gray-500 uppercase tracking-wider mb-1">Standard Rate</div>
                                    <div class="font-bold text-blue-600">{{ $country->standard_rate }}%</div>
                                </div>
                                <div>
                                    <div class="text-xs text-gray-500 uppercase tracking-wider mb-1">EU Member</div>
                                    <div class="font-medium text-green-600 flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                        </svg>
                                        Yes
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="mt-9">
            <h3 class="text-xl font-bold mb-4">Explore Other EU Countries</h3>
            <x-related-countries :country="$country" />

            <div class="mt-6 text-center">
                <a href="{{ route('html-sitemap') }}" wire:navigate class="text-blue-600 hover:text-blue-800 hover:underline text-sm font-medium">
                    View all EU country VAT pages &rarr;
                </a>
            </div>
        </div>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const el = document.querySelector(".sticky-element")
                const observer = new IntersectionObserver(
                    ([e]) => e.target.classList.toggle("is-pinned", e.intersectionRatio < 1), {
                        threshold: [1]
                    }
                );

                observer.observe(el);


                el.addEventListener('click', function() {
                    el.classList.toggle('is-pinned')
                });
            });
        </script>
    </div>
