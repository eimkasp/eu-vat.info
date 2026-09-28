@props(['opacity' => 'opacity-25'])

@once
    @push('head')
        <link rel="preload" as="image" type="image/webp" href="{{ asset('images/hero-texture-sm.webp') }}" media="(max-width: 639px)" fetchpriority="high">
        <link rel="preload" as="image" type="image/webp" href="{{ asset('images/hero-texture-md.webp') }}" media="(min-width: 640px) and (max-width: 1023px)" fetchpriority="high">
        <link rel="preload" as="image" type="image/webp" href="{{ asset('images/hero-texture-lg.webp') }}" media="(min-width: 1024px)" fetchpriority="high">
    @endpush
@endonce

<div data-atmosphere-media class="pointer-events-none absolute inset-0 -z-10 overflow-hidden" aria-hidden="true">
    <picture>
        <source media="(min-width: 1024px)" type="image/webp" srcset="{{ asset('images/hero-texture-lg.webp') }}">
        <source media="(min-width: 640px)" type="image/webp" srcset="{{ asset('images/hero-texture-md.webp') }}">
        <source type="image/webp" srcset="{{ asset('images/hero-texture-sm.webp') }}">
        <img src="{{ asset('images/eu-vat-calculator-background-sm.jpg') }}" alt="" width="1600" height="893" fetchpriority="high" decoding="async" class="size-full object-cover object-center mix-blend-luminosity {{ $opacity }}">
    </picture>
    <div class="absolute inset-0 bg-linear-to-b from-brand-deep/30 via-brand-deep/75 to-brand-deep"></div>
</div>
