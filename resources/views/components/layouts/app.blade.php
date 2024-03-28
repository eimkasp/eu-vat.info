<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')

    <title>@yield('title', 'EU VAT Info')</title>
    <meta name="description" content="@yield('meta_description', 'Our goal is to provide you with the most up-to-date information on VAT in the European Union. And help you guide VAT compliance landscape')">
    @if (config('app.adsense_id'))
        <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client={{ config('app.adsense_id') }}"
            crossorigin="anonymous"></script>
    @endif
</head>

<body>
    <x-global-header></x-global-header>

    <div class="bg-gray-50">
        {{ $slot }}
    </div>

    <x-footer></x-footer>
    <script defer data-domain="eu-vat.info" src="https://stats.businesspress.io/js/script.js"></script>

</body>

</html>
