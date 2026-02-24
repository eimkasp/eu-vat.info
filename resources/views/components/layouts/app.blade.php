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
    <style>
        :root {
            --primary: #4F46E5;
            --primary-dark: #4338CA;
            --secondary: #0EA5E9;
            --accent: #F59E0B;
            --success: #10B981;
            --warning: #F59E0B;
            --danger: #EF4444;
            --background: #F8FAFC;
            --surface: #FFFFFF;
        }
    </style>
</head>

<body class="bg-gradient-to-br from-gray-50 to-gray-100">
    <x-global-header></x-global-header>

    <div class="bg-gray-100">
    <div class="absolute top-0 left-0 w-full h-[100px] opacity-20 z-0">
    </div>
    <div class="relative z-[2]">
        @isset($slot)
            {{ $slot }}
        @else
            @yield('content')
        @endisset
        </div>
    </div>
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
</body>

</html>
