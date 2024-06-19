<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')

    <title>@yield('title', 'EU VAT Widget')</title>
    <meta name="description" content="@yield('meta_description', 'VAT Widget to calculate VAT amount in your country')">
</head>
<body>
    <div class="">
        @isset($slot)
            {{ $slot }}
        @else
            @yield('content')
        @endisset
    </div>
    @if (config('app.data_domain') && app()->isProduction())
        <script defer data-domain="{{ config('app.data_domain') }}" src="{{ config('app.plausible_script') }}"></script>
    @endif
</body>

</html>
