@extends('components.layouts.app')

@section('seo')
    <x-seo-meta
        title="{{ __('ui.error_404.meta_title') }}"
        description="{{ __('ui.error_404.meta_desc') }}"
        url="{{ url()->current() }}">
        <meta name="robots" content="noindex, follow">
    </x-seo-meta>
@endsection

@section('content')
<div class="container py-12 mt-12 pb-24">
    <x-breadcrumbs :items="[__('ui.error_404.title') => '']" />

    {{-- Hero Section --}}
    <div class="text-center mb-12 mt-6">
        <div class="inline-flex items-center justify-center w-24 h-24 bg-blue-100 rounded-full mb-6">
            <span class="text-5xl font-extrabold text-blue-600">404</span>
        </div>
        <h1 class="text-4xl sm:text-5xl font-extrabold text-gray-900 tracking-tight mb-4">
            {{ __('ui.error_404.heading') }}
        </h1>
        <p class="text-lg text-gray-600 leading-relaxed max-w-2xl mx-auto mb-8">
            {{ __('ui.error_404.message') }}
        </p>

        {{-- Primary CTAs --}}
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ locale_path('/') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-semibold shadow-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                {{ __('ui.error_404.back') }}
            </a>
            <a href="{{ locale_path('/vat-calculator') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-white text-gray-700 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors font-semibold shadow-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                {{ __('ui.error_404.tool_calculator') }}
            </a>
        </div>
    </div>

    {{-- Hint --}}
    <p class="text-center text-gray-500 font-medium mb-8 text-sm uppercase tracking-wide">{{ __('ui.error_404.search_hint') }}</p>

    {{-- VAT Tools Grid --}}
    <div class="mb-12">
        <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center gap-2">
            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
            {{ __('ui.error_404.popular_tools') }}
        </h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            {{-- Calculator --}}
            <a href="{{ locale_path('/vat-calculator') }}" class="group bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-md hover:border-blue-200 transition-all">
                <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mb-4 group-hover:bg-blue-200 transition-colors">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                </div>
                <h3 class="font-semibold text-gray-900 mb-1">{{ __('ui.error_404.tool_calculator') }}</h3>
                <p class="text-sm text-gray-500">{{ __('ui.error_404.tool_calculator_desc') }}</p>
            </a>
            {{-- Map --}}
            <a href="{{ locale_path('/vat-map') }}" class="group bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-md hover:border-green-200 transition-all">
                <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center mb-4 group-hover:bg-green-200 transition-colors">
                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <h3 class="font-semibold text-gray-900 mb-1">{{ __('ui.error_404.tool_map') }}</h3>
                <p class="text-sm text-gray-500">{{ __('ui.error_404.tool_map_desc') }}</p>
            </a>
            {{-- History --}}
            <a href="{{ locale_path('/vat-changes') }}" class="group bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-md hover:border-amber-200 transition-all">
                <div class="w-10 h-10 bg-amber-100 rounded-lg flex items-center justify-center mb-4 group-hover:bg-amber-200 transition-colors">
                    <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <h3 class="font-semibold text-gray-900 mb-1">{{ __('ui.error_404.tool_history') }}</h3>
                <p class="text-sm text-gray-500">{{ __('ui.error_404.tool_history_desc') }}</p>
            </a>
            {{-- Validator --}}
            <a href="{{ locale_path('/vat-calculator') }}" class="group bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-md hover:border-purple-200 transition-all">
                <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center mb-4 group-hover:bg-purple-200 transition-colors">
                    <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                </div>
                <h3 class="font-semibold text-gray-900 mb-1">{{ __('ui.error_404.tool_validator') }}</h3>
                <p class="text-sm text-gray-500">{{ __('ui.error_404.tool_validator_desc') }}</p>
            </a>
        </div>
    </div>

    {{-- Popular EU Countries --}}
    <div class="mb-12">
        <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center gap-2">
            <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 21v-4m0 0V5a2 2 0 012-2h6.5l1 1H21l-3 6 3 6h-8.5l-1-1H5a2 2 0 00-2 2zm9-13.5V9"></path></svg>
            {{ __('ui.error_404.popular_countries') }}
        </h2>
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-6 gap-4">
            @php
                $popularCountries = [
                    ['slug' => 'germany',      'flag' => '🇩🇪', 'name' => 'Germany',      'rate' => '19%'],
                    ['slug' => 'france',       'flag' => '🇫🇷', 'name' => 'France',       'rate' => '20%'],
                    ['slug' => 'italy',        'flag' => '🇮🇹', 'name' => 'Italy',        'rate' => '22%'],
                    ['slug' => 'spain',        'flag' => '🇪🇸', 'name' => 'Spain',        'rate' => '21%'],
                    ['slug' => 'netherlands',  'flag' => '🇳🇱', 'name' => 'Netherlands',  'rate' => '21%'],
                    ['slug' => 'belgium',      'flag' => '🇧🇪', 'name' => 'Belgium',      'rate' => '21%'],
                    ['slug' => 'poland',       'flag' => '🇵🇱', 'name' => 'Poland',       'rate' => '23%'],
                    ['slug' => 'austria',      'flag' => '🇦🇹', 'name' => 'Austria',      'rate' => '20%'],
                    ['slug' => 'portugal',     'flag' => '🇵🇹', 'name' => 'Portugal',     'rate' => '23%'],
                    ['slug' => 'ireland',      'flag' => '🇮🇪', 'name' => 'Ireland',      'rate' => '23%'],
                    ['slug' => 'sweden',       'flag' => '🇸🇪', 'name' => 'Sweden',       'rate' => '25%'],
                    ['slug' => 'hungary',      'flag' => '🇭🇺', 'name' => 'Hungary',      'rate' => '27%'],
                ];
            @endphp

            @foreach($popularCountries as $c)
                <a href="{{ locale_path('/country/' . $c['slug']) }}"
                   class="flex items-center gap-3 bg-white rounded-lg border border-gray-100 p-4 hover:shadow-md hover:border-blue-200 transition-all group"
                   title="{{ $c['name'] }} VAT rates and calculator">
                    <span class="text-2xl">{{ $c['flag'] }}</span>
                    <div>
                        <span class="font-semibold text-gray-900 group-hover:text-blue-600 transition-colors text-sm">{{ $c['name'] }}</span>
                        <span class="block text-xs text-gray-500">{{ __('ui.stats.standard_rate') }}: {{ $c['rate'] }}</span>
                    </div>
                </a>
            @endforeach
        </div>
        <div class="text-center mt-6">
            <a href="{{ locale_path('/') }}" class="inline-flex items-center gap-2 text-blue-600 hover:text-blue-800 font-semibold hover:underline">
                {{ __('ui.error_404.all_countries_cta') }}
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
            </a>
        </div>
    </div>

    {{-- Resources & Data --}}
    <div class="mb-8">
        <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center gap-2">
            <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4"></path></svg>
            {{ __('ui.error_404.explore_resources') }}
        </h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <a href="/api/llm/vat-rates" class="flex items-start gap-3 bg-white rounded-xl border border-gray-100 p-5 hover:shadow-md hover:border-blue-200 transition-all group">
                <div class="w-8 h-8 bg-sky-100 rounded-lg flex items-center justify-center flex-shrink-0 mt-0.5 group-hover:bg-sky-200 transition-colors">
                    <svg class="w-4 h-4 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path></svg>
                </div>
                <div>
                    <span class="font-semibold text-gray-900 group-hover:text-blue-600 transition-colors text-sm">{{ __('ui.error_404.resource_api') }}</span>
                    <p class="text-xs text-gray-500 mt-1">{{ __('ui.error_404.resource_api_desc') }}</p>
                </div>
            </a>
            <a href="/llms.txt" class="flex items-start gap-3 bg-white rounded-xl border border-gray-100 p-5 hover:shadow-md hover:border-blue-200 transition-all group">
                <div class="w-8 h-8 bg-violet-100 rounded-lg flex items-center justify-center flex-shrink-0 mt-0.5 group-hover:bg-violet-200 transition-colors">
                    <svg class="w-4 h-4 text-violet-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                </div>
                <div>
                    <span class="font-semibold text-gray-900 group-hover:text-blue-600 transition-colors text-sm">{{ __('ui.error_404.resource_llms') }}</span>
                    <p class="text-xs text-gray-500 mt-1">{{ __('ui.error_404.resource_llms_desc') }}</p>
                </div>
            </a>
            <a href="{{ locale_path('/sitemap') }}" class="flex items-start gap-3 bg-white rounded-xl border border-gray-100 p-5 hover:shadow-md hover:border-blue-200 transition-all group">
                <div class="w-8 h-8 bg-emerald-100 rounded-lg flex items-center justify-center flex-shrink-0 mt-0.5 group-hover:bg-emerald-200 transition-colors">
                    <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                </div>
                <div>
                    <span class="font-semibold text-gray-900 group-hover:text-blue-600 transition-colors text-sm">{{ __('ui.error_404.resource_sitemap') }}</span>
                    <p class="text-xs text-gray-500 mt-1">{{ __('ui.error_404.resource_sitemap_desc') }}</p>
                </div>
            </a>
            <a href="https://github.com/eimkasp/eu-vat.info" target="_blank" rel="noopener noreferrer" class="flex items-start gap-3 bg-white rounded-xl border border-gray-100 p-5 hover:shadow-md hover:border-blue-200 transition-all group">
                <div class="w-8 h-8 bg-gray-200 rounded-lg flex items-center justify-center flex-shrink-0 mt-0.5 group-hover:bg-gray-300 transition-colors">
                    <svg class="w-4 h-4 text-gray-700" fill="currentColor" viewBox="0 0 24 24"><path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"></path></svg>
                </div>
                <div>
                    <span class="font-semibold text-gray-900 group-hover:text-blue-600 transition-colors text-sm">{{ __('ui.error_404.resource_github') }}</span>
                    <p class="text-xs text-gray-500 mt-1">{{ __('ui.error_404.resource_github_desc') }}</p>
                </div>
            </a>
        </div>
    </div>
</div>
@endsection
