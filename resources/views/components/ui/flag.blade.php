@props(['iso' => null, 'alt' => '', 'size' => 'md', 'lazy' => true])

@php
    $code = strtolower((string) $iso);
    $code = $code === 'el' ? 'gr' : ($code === 'uk' ? 'gb' : $code);
    $dimensions = [
        'xs' => ['class' => 'h-3 w-4', 'width' => 16, 'height' => 12],
        'sm' => ['class' => 'h-3.5 w-[1.125rem]', 'width' => 18, 'height' => 14],
        'md' => ['class' => 'h-4 w-[1.375rem]', 'width' => 22, 'height' => 16],
        'lg' => ['class' => 'h-6 w-8', 'width' => 32, 'height' => 24],
        'xl' => ['class' => 'h-9 w-12', 'width' => 48, 'height' => 36],
    ][$size] ?? ['class' => 'h-4 w-[1.375rem]', 'width' => 22, 'height' => 16];
    $sizeClass = preg_match('/(^|\s)h-/', (string) $attributes->get('class')) ? '' : ' '.$dimensions['class'];
@endphp

@if(preg_match('/^[a-z]{2}$/', $code))
    <img
        src="{{ asset('images/flags/'.$code.'.svg') }}"
        alt="{{ $alt }}"
        width="{{ $dimensions['width'] }}"
        height="{{ $dimensions['height'] }}"
        @if($lazy) loading="lazy" @endif
        decoding="async"
        {{ $attributes->merge(['class' => 'app-flag'.$sizeClass]) }}
    >
@else
    <span {{ $attributes->merge(['class' => 'app-flag bg-surface-muted'.$sizeClass]) }} aria-hidden="true"></span>
@endif
