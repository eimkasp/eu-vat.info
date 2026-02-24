@section('seo')
    <x-seo-meta 
        title="HTML Sitemap - All EU VAT Pages | EU VAT Info"
        description="Complete sitemap of EU VAT Info. Browse all pages including VAT calculators, country guides, validators, and tools for all 27 EU member states."
        url="{{ url('/sitemap') }}">
        <script type="application/ld+json">
        {
            "@context": "https://schema.org",
            "@type": "CollectionPage",
            "name": "EU VAT Info - Complete Sitemap",
            "description": "Browse all pages on EU VAT Info including country-specific VAT calculators, validators, guides, and tools.",
            "url": "{{ url('/sitemap') }}",
            "isPartOf": {
                "@type": "WebSite",
                "name": "EU VAT Info",
                "url": "{{ url('/') }}"
            }
        }
        </script>
    </x-seo-meta>
@endsection

<div class="container py-12 mt-12 pb-24">
    <x-breadcrumbs :items="['Sitemap' => '']" />

    <div class="mb-10 mt-6">
        <h1 class="text-4xl sm:text-5xl font-extrabold text-gray-900 tracking-tight mb-4">
            Site <span class="text-blue-600">Map</span>
        </h1>
        <p class="text-lg text-gray-600 leading-relaxed max-w-3xl">
            Explore every page on EU VAT Info. Find VAT calculators, country guides, rate validators, and tools for all 27 European Union member states.
        </p>
    </div>

    {{-- Main Pages --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-12">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h2 class="text-xl font-bold text-gray-900 mb-4 flex items-center gap-2">
                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                </svg>
                Main Pages
            </h2>
            <ul class="space-y-3">
                <li>
                    <a href="{{ route('home') }}" wire:navigate class="flex items-center gap-2 text-blue-600 hover:text-blue-800 hover:underline font-medium">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        Home - All EU Countries
                    </a>
                    <p class="text-sm text-gray-500 ml-6">Overview of VAT rates for all 27 EU member states</p>
                </li>
                <li>
                    <a href="{{ route('vat-calculator') }}" wire:navigate class="flex items-center gap-2 text-blue-600 hover:text-blue-800 hover:underline font-medium">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        VAT Calculator
                    </a>
                    <p class="text-sm text-gray-500 ml-6">Calculate VAT amounts for any EU country with custom rates</p>
                </li>
                <li>
                    <a href="{{ route('vat-map') }}" wire:navigate class="flex items-center gap-2 text-blue-600 hover:text-blue-800 hover:underline font-medium">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        Interactive VAT Map
                    </a>
                    <p class="text-sm text-gray-500 ml-6">Visual heatmap of standard VAT rates across Europe</p>
                </li>
                <li>
                    <a href="{{ route('widget.embed') }}" wire:navigate class="flex items-center gap-2 text-blue-600 hover:text-blue-800 hover:underline font-medium">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        Embeddable VAT Widget
                    </a>
                    <p class="text-sm text-gray-500 ml-6">Embed the VAT calculator on your own website</p>
                </li>
                <li>
                    <a href="{{ route('vat-changes') }}" wire:navigate class="flex items-center gap-2 text-blue-600 hover:text-blue-800 hover:underline font-medium">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        VAT Rate History
                    </a>
                    <p class="text-sm text-gray-500 ml-6">Complete history of VAT rate changes across all EU countries</p>
                </li>
            </ul>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h2 class="text-xl font-bold text-gray-900 mb-4 flex items-center gap-2">
                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                API & Data
            </h2>
            <ul class="space-y-3">
                <li>
                    <a href="/llms.txt" class="flex items-center gap-2 text-blue-600 hover:text-blue-800 hover:underline font-medium">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        llms.txt - AI/LLM Documentation
                    </a>
                    <p class="text-sm text-gray-500 ml-6">Structured data for AI agents and language models</p>
                </li>
                <li>
                    <a href="/llms-full.txt" class="flex items-center gap-2 text-blue-600 hover:text-blue-800 hover:underline font-medium">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        Full VAT Rates (Markdown)
                    </a>
                    <p class="text-sm text-gray-500 ml-6">Complete Markdown table of all EU VAT rates</p>
                </li>
                <li>
                    <a href="/api/llm/vat-rates" class="flex items-center gap-2 text-blue-600 hover:text-blue-800 hover:underline font-medium">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        JSON API for AI/RAG
                    </a>
                    <p class="text-sm text-gray-500 ml-6">JSON endpoint optimized for RAG and LLM context retrieval</p>
                </li>
                <li>
                    <a href="/sitemap.xml" class="flex items-center gap-2 text-blue-600 hover:text-blue-800 hover:underline font-medium">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        XML Sitemap
                    </a>
                    <p class="text-sm text-gray-500 ml-6">Machine-readable sitemap for search engines</p>
                </li>
            </ul>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h2 class="text-xl font-bold text-gray-900 mb-4 flex items-center gap-2">
                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
                </svg>
                External Resources
            </h2>
            <ul class="space-y-3">
                <li>
                    <a href="https://ec.europa.eu/taxation_customs/vies/" target="_blank" rel="noopener noreferrer" class="flex items-center gap-2 text-blue-600 hover:text-blue-800 hover:underline font-medium">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                        EU VIES VAT Validation
                    </a>
                    <p class="text-sm text-gray-500 ml-6">Official European Commission VAT number verification</p>
                </li>
                <li>
                    <a href="https://europa.eu/youreurope/business/taxation/vat/" target="_blank" rel="noopener noreferrer" class="flex items-center gap-2 text-blue-600 hover:text-blue-800 hover:underline font-medium">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                        Your Europe - VAT Guide
                    </a>
                    <p class="text-sm text-gray-500 ml-6">Official EU guide on VAT for businesses</p>
                </li>
                <li>
                    <a href="https://pdf.businesspress.io/" target="_blank" rel="noopener noreferrer" class="flex items-center gap-2 text-blue-600 hover:text-blue-800 hover:underline font-medium">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                        PDF Tools by BusinessPress
                    </a>
                    <p class="text-sm text-gray-500 ml-6">Free online PDF tools for invoices and documents</p>
                </li>
                <li>
                    <a href="https://github.com/eimkasp/eu-vat.info" target="_blank" rel="noopener noreferrer" class="flex items-center gap-2 text-blue-600 hover:text-blue-800 hover:underline font-medium">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                        GitHub Repository
                    </a>
                    <p class="text-sm text-gray-500 ml-6">Open source code for EU VAT Info</p>
                </li>
            </ul>
        </div>
    </div>

    {{-- Country Pages Grid --}}
    <div class="mb-8">
        <h2 class="text-2xl font-bold text-gray-900 mb-2">All EU Country VAT Pages</h2>
        <p class="text-gray-600 mb-6">Browse VAT information, calculators, and validators for each EU member state.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
        @foreach($countries as $country)
            @php
                $iso = strtoupper($country->iso_code);
                $flag = '';
                if (strlen($iso) === 2) {
                    $flag = mb_chr(ord($iso[0]) + 127397) . mb_chr(ord($iso[1]) + 127397);
                }
            @endphp
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 hover:shadow-md transition-shadow">
                <div class="flex items-center gap-3 mb-4 pb-3 border-b border-gray-100">
                    <img src="https://flagcdn.com/h40/{{ strtolower($country->iso_code) }}.jpg" 
                         alt="{{ $country->name }} flag" 
                         class="w-8 h-auto rounded shadow-sm"
                         loading="lazy">
                    <div>
                        <h3 class="font-bold text-gray-900">{{ $country->name }}</h3>
                        <span class="text-sm text-gray-500">Standard Rate: <strong class="text-blue-600">{{ $country->standard_rate }}%</strong></span>
                    </div>
                </div>
                <ul class="space-y-2 text-sm">
                    <li>
                        <a href="{{ route('country.show', $country->slug) }}" wire:navigate class="text-blue-600 hover:text-blue-800 hover:underline flex items-center gap-1">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                            {{ $country->name }} VAT Overview & Guide
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('country.tab', ['slug' => $country->slug, 'tab' => 'vat-calculator']) }}" wire:navigate class="text-blue-600 hover:text-blue-800 hover:underline flex items-center gap-1">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                            {{ $country->name }} VAT Calculator
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('country.tab', ['slug' => $country->slug, 'tab' => 'vat-validator']) }}" wire:navigate class="text-blue-600 hover:text-blue-800 hover:underline flex items-center gap-1">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                            Validate {{ $country->name }} VAT Numbers
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('vat-calculator.country', $country->slug) }}" wire:navigate class="text-blue-600 hover:text-blue-800 hover:underline flex items-center gap-1">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                            {{ $country->name }} Standalone Calculator
                        </a>
                    </li>
                </ul>
            </div>
        @endforeach
    </div>

    {{-- Internal Linking SEO Section --}}
    <div class="mt-16 bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl p-8 border border-blue-200">
        <h2 class="text-2xl font-bold text-gray-900 mb-4">About EU VAT Info</h2>
        <div class="prose prose-blue max-w-none text-gray-700">
            <p>
                EU VAT Info provides comprehensive, daily-updated VAT information for all 27 European Union member states. 
                Use our <a href="{{ route('vat-calculator') }}" wire:navigate class="text-blue-600 hover:underline font-medium">VAT Calculator</a> to compute VAT amounts instantly, 
                explore the <a href="{{ route('vat-map') }}" wire:navigate class="text-blue-600 hover:underline font-medium">interactive VAT Map</a> to visualize rates across Europe, 
                or browse all 27 country pages below for detailed VAT guides and validators.
            </p>
            <p>
                Each country page includes a detailed VAT guide, a country-specific calculator with custom rate support, and a VIES-powered VAT number validator. 
                Developers and AI agents can access our data via the <a href="/llms.txt" class="text-blue-600 hover:underline font-medium">llms.txt</a> standard 
                or the <a href="/api/llm/vat-rates" class="text-blue-600 hover:underline font-medium">JSON API</a>.
            </p>
        </div>
    </div>
</div>
