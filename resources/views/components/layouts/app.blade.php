<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>

    <title>{{ $title ?? 'Page Title' }}</title>
</head>

<body>
    <x-global-header></x-global-header>
    
    <div>
        {{ $slot }}
    </div>

    <x-footer></x-footer>

</body>

</html>
