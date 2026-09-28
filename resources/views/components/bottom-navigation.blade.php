@use('App\Support\SiteNavigation')

@php
    $items = [
        ['label' => __('ui.bottom_nav.home'), 'url' => locale_path('/'), 'icon' => 'home', 'active' => SiteNavigation::isActive('home')],
        ['label' => __('ui.bottom_nav.calculator'), 'url' => locale_path('/vat-calculator'), 'icon' => 'calculator', 'active' => SiteNavigation::isActive('vat-calculator*', 'shared-calculation', 'top-calculations*')],
        ['label' => __('ui.bottom_nav.validator'), 'url' => locale_path('/vat-number-validator'), 'icon' => 'shield-check', 'active' => SiteNavigation::isActive('vies-validator*')],
        ['label' => __('ui.bottom_nav.map'), 'url' => locale_path('/vat-map'), 'icon' => 'map', 'active' => SiteNavigation::isActive('vat-map')],
    ];
@endphp

<nav class="fixed inset-x-0 bottom-0 z-30 border-t border-line bg-surface/95 pb-[env(safe-area-inset-bottom)] backdrop-blur supports-[backdrop-filter]:bg-surface/85 md:hidden" aria-label="{{ __('ui.nav.mobile') }}">
    <div class="mx-auto grid h-[4.25rem] max-w-lg grid-cols-5">
        @foreach($items as $item)
            <a href="{{ $item['url'] }}" @class(['relative flex flex-col items-center justify-center gap-1 text-[0.6875rem] font-semibold transition-colors', 'text-action' => $item['active'], 'text-ink-muted hover:text-ink' => ! $item['active']]) @if($item['active']) aria-current="page" @endif>
                @if($item['active'])
                    <span class="absolute inset-x-5 top-0 h-0.5 rounded-full bg-action" aria-hidden="true"></span>
                @endif
                <x-ui.icon :name="$item['icon']" class="size-5" />
                <span>{{ $item['label'] }}</span>
            </a>
        @endforeach
        <button type="button" @click="$store.palette.show()" class="flex flex-col items-center justify-center gap-1 text-[0.6875rem] font-semibold text-ink-muted transition-colors hover:text-ink">
            <x-ui.icon name="search" class="size-5" />
            <span>{{ __('ui.nav.search') }}</span>
        </button>
    </div>
</nav>
