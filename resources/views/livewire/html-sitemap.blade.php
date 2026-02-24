@section('seo')
    <x-seo-meta 
        title="{{ __('ui.sitemap.meta_title') }}"
        description="{{ __('ui.sitemap.meta_desc') }}"
        url="{{ url(locale_path('/sitemap')) }}">
        <script type="application/ld+json">
        {
            "@context": "https://schema.org",
            "@type": "CollectionPage",
            "name": "{{ __('ui.sitemap.schema_name') }}",
            "description": "{{ __('ui.sitemap.schema_desc') }}",
            "url": "{{ url(locale_path('/sitemap')) }}",
            "isPartOf": {
                "@type": "WebSite",
                "name": "{{ __('ui.site_name') }}",
                "url": "{{ url(locale_path('/')) }}"
            }
        }
        </script>
    </x-seo-meta>
@endsection

<div class="container py-12 mt-12 pb-24">
    <x-breadcrumbs :items="[__('ui.breadcrumbs.sitemap') => '']" />

    <div class="mb-10 mt-6">
        <h1 class="text-4xl sm:text-5xl font-extrabold text-gray-900 tracking-tight mb-4">
            {{ __('ui.sitemap.heading') }} <span class="text-blue-600">{{ __('ui.sitemap.heading_accent') }}</span>
        </h1>
        <p class="text-lg text-gray-600 leading-relaxed max-w-3xl">
            {{ __('ui.sitemap.subtitle') }}
        </p>
    </div>

    {{-- Main Pages --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-12">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h2 class="text-xl font-bold text-gray-900 mb-4 flex items-center gap-2">
                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                </svg>
                {{ __('ui.sitemap.main_pages') }}
            </h2>
            <ul class="space-y-3">
                <li>
                    <a href="{{ locale_path('/') }}" class="flex items-center gap-2 text-blue-600 hover:text-blue-800 hover:underline font-medium">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        {{ __('ui.sitemap.home_all') }}
                    </a>
                    <p class="text-sm text-gray-500 ml-6">{{ __('ui.sitemap.home_desc') }}</p>
                </li>
                <li>
                    <a href="{{ locale_path('/vat-calculator') }}" class="flex items-center gap-2 text-blue-600 hover:text-blue-800 hover:underline font-medium">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        {{ __('ui.sitemap.calculator') }}
                    </a>
                    <p class="text-sm text-gray-500 ml-6">{{ __('ui.sitemap.calculator_desc') }}</p>
                </li>
                <li>
                    <a href="{{ locale_path('/vat-map') }}" class="flex items-center gap-2 text-blue-600 hover:text-blue-800 hover:underline font-medium">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        {{ __('ui.sitemap.map') }}
                    </a>
                    <p class="text-sm text-gray-500 ml-6">{{ __('ui.sitemap.map_desc') }}</p>
                </li>
                <li>
                    <a href="{{ route('widget.embed') }}" class="flex items-center gap-2 text-blue-600 hover:text-blue-800 hover:underline font-medium">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        {{ __('ui.sitemap.embed') }}
                    </a>
                    <p class="text-sm text-gray-500 ml-6">{{ __('ui.sitemap.embed_desc') }}</p>
                </li>
                <li>
                    <a href="{{ locale_path('/vat-changes') }}" class="flex items-center gap-2 text-blue-600 hover:text-blue-800 hover:underline font-medium">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        {{ __('ui.sitemap.history') }}
                    </a>
                    <p class="text-sm text-gray-500 ml-6">{{ __('ui.sitemap.history_desc') }}</p>
                </li>
            </ul>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h2 class="text-xl font-bold text-gray-900 mb-4 flex items-center gap-2">
                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                {{ __('ui.sitemap.api_data') }}
            </h2>
            <ul class="space-y-3">
                <li>
                    <a href="/llms.txt" class="flex items-center gap-2 text-blue-600 hover:text-blue-800 hover:underline font-medium">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        {{ __('ui.sitemap.llms_txt') }}
                    </a>
                    <p class="text-sm text-gray-500 ml-6">{{ __('ui.sitemap.llms_txt_desc') }}</p>
                </li>
                <li>
                    <a href="/llms-full.txt" class="flex items-center gap-2 text-blue-600 hover:text-blue-800 hover:underline font-medium">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        {{ __('ui.sitemap.full_vat_rates') }}
                    </a>
                    <p class="text-sm text-gray-500 ml-6">{{ __('ui.sitemap.full_vat_rates_desc') }}</p>
                </li>
                <li>
                    <a href="/api/llm/vat-rates" class="flex items-center gap-2 text-blue-600 hover:text-blue-800 hover:underline font-medium">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        {{ __('ui.sitemap.json_api') }}
                    </a>
                    <p class="text-sm text-gray-500 ml-6">{{ __('ui.sitemap.json_api_desc') }}</p>
                </li>
                <li>
                    <a href="/sitemap.xml" class="flex items-center gap-2 text-blue-600 hover:text-blue-800 hover:underline font-medium">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        {{ __('ui.sitemap.xml_sitemap') }}
                    </a>
                    <p class="text-sm text-gray-500 ml-6">{{ __('ui.sitemap.xml_sitemap_desc') }}</p>
                </li>
            </ul>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h2 class="text-xl font-bold text-gray-900 mb-4 flex items-center gap-2">
                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
                </svg>
                {{ __('ui.sitemap.external_resources') }}
            </h2>
            <ul class="space-y-3">
                <li>
                    <a href="https://ec.europa.eu/taxation_customs/vies/" target="_blank" rel="noopener noreferrer" class="flex items-center gap-2 text-blue-600 hover:text-blue-800 hover:underline font-medium">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                        {{ __('ui.sitemap.vies_validation') }}
                    </a>
                    <p class="text-sm text-gray-500 ml-6">{{ __('ui.sitemap.vies_desc') }}</p>
                </li>
                <li>
                    <a href="https://europa.eu/youreurope/business/taxation/vat/" target="_blank" rel="noopener noreferrer" class="flex items-center gap-2 text-blue-600 hover:text-blue-800 hover:underline font-medium">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                        {{ __('ui.sitemap.europe_guide') }}
                    </a>
                    <p class="text-sm text-gray-500 ml-6">{{ __('ui.sitemap.europe_guide_desc') }}</p>
                </li>
                <li>
                    <a href="https://pdf.businesspress.io/" target="_blank" rel="noopener noreferrer" class="flex items-center gap-2 text-blue-600 hover:text-blue-800 hover:underline font-medium">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                        {{ __('ui.sitemap.pdf_tools') }}
                    </a>
                    <p class="text-sm text-gray-500 ml-6">{{ __('ui.sitemap.pdf_tools_desc') }}</p>
                </li>
                <li>
                    <a href="https://github.com/eimkasp/eu-vat.info" target="_blank" rel="noopener noreferrer" class="flex items-center gap-2 text-blue-600 hover:text-blue-800 hover:underline font-medium">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                        {{ __('ui.sitemap.github_repo') }}
                    </a>
                    <p class="text-sm text-gray-500 ml-6">{{ __('ui.sitemap.github_desc') }}</p>
                </li>
            </ul>
        </div>
    </div>

    {{-- Country Pages Grid --}}
    <div class="mb-8">
        <h2 class="text-2xl font-bold text-gray-900 mb-2">{{ __('ui.sitemap.all_country_pages') }}</h2>
        <p class="text-gray-600 mb-6">{{ __('ui.sitemap.country_pages_desc') }}</p>
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
                        <span class="text-sm text-gray-500">{{ __('ui.sitemap.standard_rate_label') }} <strong class="text-blue-600">{{ $country->standard_rate }}%</strong></span>
                    </div>
                </div>
                <ul class="space-y-2 text-sm">
                    <li>
                        <a href="{{ locale_path('/country/' . $country->slug) }}" class="text-blue-600 hover:text-blue-800 hover:underline flex items-center gap-1">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                            {{ __('ui.sitemap.overview_guide', ['country' => $country->name]) }}
                        </a>
                    </li>
                    <li>
                        <a href="{{ locale_path('/country/' . $country->slug . '/vat-calculator') }}" class="text-blue-600 hover:text-blue-800 hover:underline flex items-center gap-1">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                            {{ __('ui.sitemap.country_calculator', ['country' => $country->name]) }}
                        </a>
                    </li>
                    <li>
                        <a href="{{ locale_path('/vat-calculator/' . $country->slug) }}" class="text-blue-600 hover:text-blue-800 hover:underline flex items-center gap-1">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                            {{ __('ui.sitemap.standalone_calculator', ['country' => $country->name]) }}
                        </a>
                    </li>
                </ul>
            </div>
        @endforeach
    </div>

    {{-- Internal Linking SEO Section --}}
    <div class="mt-16 bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl p-8 border border-blue-200">
        <h2 class="text-2xl font-bold text-gray-900 mb-4">{{ __('ui.sitemap.about_title') }}</h2>
        <div class="prose prose-blue max-w-none text-gray-700">
            <p>
                {!! __('ui.sitemap.about_p1', [
                    'calculator_link' => '<a href="' . locale_path('/vat-calculator') . '" class="text-blue-600 hover:underline font-medium">' . e(__('ui.sitemap.calculator')) . '</a>',
                    'map_link' => '<a href="' . locale_path('/vat-map') . '" class="text-blue-600 hover:underline font-medium">' . e(__('ui.sitemap.map')) . '</a>',
                ]) !!}
            </p>
            <p>
                {!! __('ui.sitemap.about_p2', [
                    'llms_link' => '<a href="/llms.txt" class="text-blue-600 hover:underline font-medium">' . e(__('ui.sitemap.about_llms_label')) . '</a>',
                    'api_link' => '<a href="/api/llm/vat-rates" class="text-blue-600 hover:underline font-medium">' . e(__('ui.sitemap.about_api_label')) . '</a>',
                ]) !!}
            </p>
        </div>
    </div>
</div>
