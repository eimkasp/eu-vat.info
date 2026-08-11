@if($isCountryPage)
@php
    $calcMetaTitle = __('ui.calculator.meta_title_country', ['country' => $selectedCountryObject->name, 'rate' => $selectedCountryObject->standard_rate]);
    $calcMetaDesc = __('ui.calculator.meta_desc_country', ['country' => $selectedCountryObject->name, 'rate' => $selectedCountryObject->standard_rate]);
    $calcCanonical = app(\App\Support\Seo\SeoPolicy::class)->localizedUrl('/vat-calculator/' . $selectedCountryObject->slug, app()->getLocale());
@endphp
@section('title', $calcMetaTitle)
@section('meta_description', $calcMetaDesc)
@section('seo')
    <x-seo-meta :title="$calcMetaTitle" :description="$calcMetaDesc" :url="$calcCanonical">
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
                'offers' => ['@type' => 'Offer', 'price' => '0', 'priceCurrency' => $selectedCountryObject->currency_code ?: 'EUR'],
                'featureList' => 'VAT calculation, Add VAT, Remove VAT, Multiple rate types',
                'about' => ['@type' => 'Country', 'name' => $selectedCountryObject->name],
            ],
        ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
        </script>
    </x-seo-meta>
@endsection
@else
@section('title', __('ui.calculator.meta_title_generic'))
@section('meta_description', __('ui.calculator.meta_desc_generic'))
@section('seo')
    <x-seo-meta :title="__('ui.calculator.meta_title_generic')" :description="__('ui.calculator.meta_desc_generic')" />
@endsection
@endif

@push('head')
    @if($isCountryPage)
        <link rel="amphtml" href="{{ url('/amp/vat-calculator/' . $selectedCountryObject->slug) }}">
        <link rel="preload" as="image" type="image/webp" href="/images/eu-vat-calculator-background-sm.webp" media="(max-width: 639px)" fetchpriority="high">
        <link rel="preload" as="image" type="image/webp" href="/images/eu-vat-calculator-background-md.webp" media="(min-width: 640px) and (max-width: 1023px)" fetchpriority="high">
        <link rel="preload" as="image" type="image/webp" href="/images/eu-vat-calculator-background-lg.webp" media="(min-width: 1024px)" fetchpriority="high">
    @else
        <link rel="preload" as="image" type="image/webp" href="/images/eu-vat-calculator-background.webp" fetchpriority="high">
    @endif
@endpush

@if($isCountryPage)
    <div class="min-h-screen bg-surface-subtle">
        <section data-country-atmosphere class="relative isolate bg-[#0b2f4f]">
            <div data-atmosphere-media class="pointer-events-none absolute inset-0 -z-10 overflow-hidden" aria-hidden="true">
                <picture class="absolute inset-0 block h-full w-full">
                    <source media="(min-width: 1024px)" type="image/webp" srcset="/images/eu-vat-calculator-background-lg.webp">
                    <source media="(min-width: 640px)" type="image/webp" srcset="/images/eu-vat-calculator-background-md.webp">
                    <source type="image/webp" srcset="/images/eu-vat-calculator-background-sm.webp">
                    <img src="/images/eu-vat-calculator-background.jpg" alt="" class="h-full w-full object-cover object-center" loading="eager" fetchpriority="high">
                </picture>
                <div class="absolute inset-0 bg-[#071f35]/80"></div>
            </div>

            <x-calculator.country-header :country="$selectedCountryObject" />

            <div class="container pb-8 sm:pb-10">
                <section id="calculator" aria-label="{{ $selectedCountryObject->name }} VAT calculation" class="scroll-mb-24">
                    <livewire:hero-calculator
                        :key="'hero-calc-' . $selectedCountryObject->id"
                        :initial-country="$selectedCountryObject->slug"
                        :show-header="false"
                        surface="country-image"
                    />
                </section>
            </div>
        </section>

        <main class="container !py-7 sm:!py-10">
            <div class="grid gap-8 xl:grid-cols-[minmax(0,2fr)_minmax(18rem,1fr)]">
                <div class="space-y-8">
                    <x-calculator.country-reference :country="$selectedCountryObject" />

                    @if($selectedCountryObject->is_eu_member)
                        <section aria-labelledby="country-guide-title" class="border border-line bg-white p-5 sm:p-6">
                            <p class="text-xs font-semibold uppercase tracking-[0.16em] text-action">European Union guidance</p>
                            <h2 id="country-guide-title" class="mt-1 text-xl font-bold text-ink">{{ __('ui.country_page.vat_guide_heading', ['country' => $selectedCountryObject->name]) }}</h2>
                            <p class="mt-3 text-sm leading-6 text-ink-muted">
                                {{ __('ui.country_page.vat_registration_text', ['country' => $selectedCountryObject->name, 'rate' => $selectedCountryObject->standard_rate]) }}
                            </p>

                            <div class="mt-5 flex flex-wrap gap-3 border-t border-line pt-5">
                                @if($selectedCountryObject->vies_available)
                                    <a href="{{ locale_path('/vat-number-validator/' . $selectedCountryObject->slug) }}" class="inline-flex min-h-11 items-center rounded-md bg-ink px-4 text-sm font-semibold text-white hover:bg-slate-900 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-action">
                                        {{ __('ui.country_page.validate_vat_cta', ['country' => $selectedCountryObject->name]) }}
                                    </a>
                                @endif
                                @if($selectedCountryObject->hasVatHistory())
                                    <a href="{{ locale_path('/vat-rates/' . $selectedCountryObject->slug . '/history') }}" class="inline-flex min-h-11 items-center rounded-md border border-line px-4 text-sm font-semibold text-ink hover:border-action hover:text-action">
                                        {{ __('ui.country_page.rate_history_link') }}
                                    </a>
                                @endif
                                <a href="{{ locale_path('/vat-map') }}" class="inline-flex min-h-11 items-center rounded-md border border-line px-4 text-sm font-semibold text-ink hover:border-action hover:text-action">
                                    {{ __('ui.country_page.vat_map_link') }}
                                </a>
                            </div>

                            @php
                                $comparisonPairs = app(\App\Services\Seo\InternalLinkService::class)->approvedPairsFor($selectedCountryObject);
                                $categoryRules = app(\App\Services\Seo\VatCategorySeoService::class)->rulesForCountry($selectedCountryObject->slug);
                            @endphp
                            @if($comparisonPairs->isNotEmpty() || $categoryRules->isNotEmpty())
                                <div class="mt-5 flex flex-wrap gap-x-5 gap-y-2 border-t border-line pt-5 text-sm">
                                    @foreach($comparisonPairs as $comparisonPair)
                                        @php
                                            $otherSlug = $comparisonPair[0] === $selectedCountryObject->slug ? $comparisonPair[1] : $comparisonPair[0];
                                            $otherCountry = \App\Models\Country::where('slug', $otherSlug)->where('is_eu_member', true)->first();
                                        @endphp
                                        @if($otherCountry)
                                            <a class="font-semibold text-action hover:underline" href="{{ locale_path('/compare/' . implode('-vs-', $comparisonPair) . '-vat') }}">Compare with {{ $otherCountry->name }} →</a>
                                        @endif
                                    @endforeach
                                    @foreach($categoryRules as $categoryRule)
                                        <a class="font-semibold text-action hover:underline" href="{{ locale_path('/vat-rates/' . $selectedCountryObject->slug . '/categories/' . $categoryRule->category_slug) }}">{{ $categoryRule->category_name }} VAT rate →</a>
                                    @endforeach
                                </div>
                            @endif
                        </section>
                    @endif
                </div>

                <aside class="space-y-6">
                    <section aria-labelledby="related-calculators-title" class="border border-line bg-white p-5">
                        <h2 id="related-calculators-title" class="text-lg font-bold text-ink">{{ __('ui.country_page.related') }}</h2>
                        <div class="mt-4">
                            <x-related-countries :country="$selectedCountryObject" />
                        </div>
                    </section>
                    <x-saved-searches />
                    <x-country-calculator-list />
                </aside>
            </div>
        </main>
    </div>
@else
    <div class="min-h-screen">
        <div class="relative pb-12 pt-4">
            <div class="absolute inset-0 z-0">
                <picture>
                    <source type="image/webp" srcset="/images/eu-vat-calculator-background.webp">
                    <img src="/images/eu-vat-calculator-background.jpg" alt="" role="presentation" class="h-full w-full object-cover" loading="eager" fetchpriority="high">
                </picture>
                <div class="absolute inset-0 bg-black/70"></div>
            </div>

            <div class="container relative">
                <x-site-breadcrumbs variant="dark" :items="[__('ui.calculator.breadcrumb_label') => '']" />
                <div class="mb-6 mt-3 text-center">
                    <h1 class="text-3xl font-extrabold tracking-tight text-white sm:text-4xl lg:text-5xl">{{ __('ui.calculator.european_heading') }}</h1>
                    <p class="mx-auto mt-3 max-w-2xl text-base leading-relaxed text-white/90 sm:text-lg">{{ __('ui.calculator.generic_subtitle') }}</p>
                </div>
                <livewire:hero-calculator :key="'hero-calc-default'" :show-header="false" />
            </div>
        </div>

        <main class="container !py-12">
            <div class="grid gap-10 lg:grid-cols-12">
                <div class="lg:col-span-8">
                    <div class="border border-line bg-white p-6">
                        <livewire:europe-map />
                    </div>
                </div>
                <aside class="space-y-6 lg:col-span-4">
                    <x-saved-searches />
                    <x-country-calculator-list />
                </aside>
            </div>
        </main>
    </div>
@endif
