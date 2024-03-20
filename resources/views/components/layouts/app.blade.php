<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>{{ $title ?? 'Page Title' }}</title>
    </head>
    <body>
    <header>
    <nav>
    <a href="/" wire:navigate>Home</a>
    <a href="/counter" wire:navigate>Counter</a>
    <a href="/countries" wire:navigate>Countries</a>
</nav>
    </header>
        {{ $slot }}
    </body>
</html>
