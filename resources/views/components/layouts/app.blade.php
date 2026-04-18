<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="manifest" href="/manifest.json">
    <meta name="theme-color" content="#3b82f6">
    @vite('resources/css/app.css')

    <!-- SEO Meta Tags -->
    @hasSection('seo')
        @yield('seo')
    @else
        <x-seo-meta />
    @endif

    <!-- hreflang tags for all supported locales -->
    @php
        $currentPath = request()->path();
        $supportedLocales = array_keys(config('translation.supported_languages', []));
        $defaultLocale = config('translation.default_language', 'en');
        // Strip existing locale prefix
        $cleanPath = preg_replace('#^(' . implode('|', $supportedLocales) . ')(/|$)#', '/', $currentPath);
        $cleanPath = $cleanPath === '' ? '/' : $cleanPath;
    @endphp
    <link rel="alternate" hreflang="x-default" href="{{ url($cleanPath === '/' ? '/' : $cleanPath) }}">
    @foreach($supportedLocales as $hrefLocale)
        @if($hrefLocale === $defaultLocale)
            <link rel="alternate" hreflang="{{ $hrefLocale }}" href="{{ url($cleanPath === '/' ? '/' : $cleanPath) }}">
        @else
            <link rel="alternate" hreflang="{{ $hrefLocale }}" href="{{ url('/' . $hrefLocale . ($cleanPath === '/' ? '' : $cleanPath)) }}">
        @endif
    @endforeach

    @stack('head')
    
    <script>
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', () => {
                navigator.serviceWorker.register('/sw.js')
                    .then(registration => {
                        console.log('ServiceWorker registration successful with scope: ', registration.scope);
                    }, err => {
                        console.log('ServiceWorker registration failed: ', err);
                    });
            });
        }
    </script>

    @if (config('app.adsense_id') && app()->isProduction())
        <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client={{ config('app.adsense_id') }}"
            crossorigin="anonymous"></script>
    @endif
    @if (config('app.data_domain') && app()->isProduction())
        <script defer data-domain="eu-vat.info" src="https://stats.businesspress.io/js/script.js"></script>
    @endif

</head>

<body class="bg-gradient-to-br from-gray-50 to-gray-100">
    {{-- SVG sprite sheet — rendered once, referenced by all components --}}
    @stack('svg-sprites')
    <a href="#main-content" class="sr-only focus:not-sr-only focus:absolute focus:top-0 focus:left-0 focus:bg-blue-600 focus:text-white focus:p-3 focus:z-50 focus:rounded-br-lg">{{ __('ui.skip_to_content') }}</a>
    <x-global-header></x-global-header>

    <main id="main-content" class="bg-gray-100">
    <div class="absolute top-0 left-0 w-full h-[100px] opacity-20 z-0">
    </div>
    <div class="relative z-[2]">
        @isset($slot)
            {{ $slot }}
        @else
            @yield('content')
        @endisset
        </div>
    </main>
    @if (config('app.adsense_id') && app()->isProduction())
        <!-- Default -->
        <ins class="adsbygoogle" style="display:block" data-ad-client="ca-pub-3925599852702124" data-ad-slot="1306180870"
            data-ad-format="auto" data-full-width-responsive="true"></ins>
        <script>
            (adsbygoogle = window.adsbygoogle || []).push({});
        </script>
    @endif
    <x-footer></x-footer>
    <x-toast />

    @if (config('app.cookiebot_id') && app()->isProduction())
        <script defer id="Cookiebot" src="https://consent.cookiebot.com/uc.js" data-cbid="{{ config('app.cookiebot_id') }}"
            data-blockingmode="auto" type="text/javascript"></script>
    @endif

    {{-- WebMCP — expose site tools to AI agents via the browser --}}
    {{-- data-cfasync=false prevents Cloudflare Rocket Loader from deferring this script --}}
    <script data-cfasync="false">
    (function() {
        if (!navigator.modelContext) return;

        const baseUrl = @json(rtrim(config('app.url'), '/'));

        navigator.modelContext.registerTool({
            name: 'get_all_vat_rates',
            description: 'Get current VAT rates (standard, reduced, super-reduced, parking) for all 27 EU member states.',
            inputSchema: { type: 'object', properties: {}, additionalProperties: false },
            async execute() {
                const res = await fetch(baseUrl + '/api/countries');
                return await res.json();
            }
        });

        navigator.modelContext.registerTool({
            name: 'get_country_vat_rate',
            description: 'Get VAT rates for a specific EU country by name, ISO code, or slug.',
            inputSchema: {
                type: 'object',
                properties: {
                    country: { type: 'string', description: 'Country name, ISO code (e.g. DE), or slug (e.g. germany)' }
                },
                required: ['country'],
                additionalProperties: false
            },
            async execute({ country }) {
                const res = await fetch(baseUrl + '/api/countries/' + encodeURIComponent(country));
                return await res.json();
            }
        });

        navigator.modelContext.registerTool({
            name: 'calculate_vat',
            description: 'Calculate VAT for a given amount and EU country. Returns net, gross, and VAT amounts.',
            inputSchema: {
                type: 'object',
                properties: {
                    amount: { type: 'number', description: 'Monetary amount' },
                    country: { type: 'string', description: 'Country name, ISO code, or slug' },
                    mode: { type: 'string', enum: ['add', 'remove'], description: 'add = net to gross, remove = gross to net. Default: add' },
                    rate_type: { type: 'string', enum: ['standard', 'reduced', 'super_reduced', 'parking'], description: 'VAT rate type. Default: standard' }
                },
                required: ['amount', 'country'],
                additionalProperties: false
            },
            async execute({ amount, country, mode, rate_type }) {
                const params = new URLSearchParams({ amount, country });
                if (mode) params.set('mode', mode);
                if (rate_type) params.set('rate_type', rate_type);
                const res = await fetch(baseUrl + '/api/llm/vat-rates?' + params);
                return await res.json();
            }
        });

        navigator.modelContext.registerTool({
            name: 'validate_vat_number',
            description: 'Validate an EU VAT number against the official VIES database. Returns validity, company name, and address.',
            inputSchema: {
                type: 'object',
                properties: {
                    country_code: { type: 'string', description: 'Two-letter country code (use EL for Greece)' },
                    vat_number: { type: 'string', description: 'VAT number without country prefix' }
                },
                required: ['country_code', 'vat_number'],
                additionalProperties: false
            },
            async execute({ country_code, vat_number }) {
                const res = await fetch(baseUrl + '/api/vat/validation/validate', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'Accept': 'application/json' },
                    body: JSON.stringify({ country_code, vat_number })
                });
                return await res.json();
            }
        });

        navigator.modelContext.registerTool({
            name: 'search_countries',
            description: 'Navigate to the EU VAT info homepage or search for a specific country page.',
            inputSchema: {
                type: 'object',
                properties: {
                    query: { type: 'string', description: 'Country name or slug to navigate to (optional)' }
                },
                additionalProperties: false
            },
            async execute({ query }) {
                if (query) {
                    window.location.href = baseUrl + '/vat-calculator/' + encodeURIComponent(query);
                } else {
                    window.location.href = baseUrl;
                }
                return { navigated: true, url: window.location.href };
            }
        });
    })();
    </script>
</body>

</html>
