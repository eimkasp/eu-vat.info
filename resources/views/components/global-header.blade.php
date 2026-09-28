@use('App\Support\SiteNavigation')

@php
    $tools = SiteNavigation::tools();
    $toolsActive = SiteNavigation::isActive('tools', 'vat-map', 'vat-changes*', 'widget.*', 'vat-validation-api', 'vat-dataset');
    $primary = [
        ['label' => __('ui.nav.all_countries'), 'url' => locale_path('/'), 'active' => SiteNavigation::isActive('home')],
        ['label' => __('ui.nav.vat_calculator'), 'url' => locale_path('/vat-calculator'), 'active' => SiteNavigation::isActive('vat-calculator*', 'shared-calculation', 'top-calculations*')],
        ['label' => __('ui.nav.validator_short'), 'url' => locale_path('/vat-number-validator'), 'active' => SiteNavigation::isActive('vies-validator*')],
    ];
    $navLink = 'inline-flex h-10 items-center whitespace-nowrap rounded-lg px-3 text-sm font-medium transition-colors duration-150';
@endphp

<header x-data="{ menu: false }" @keydown.escape.window="menu = false" class="sticky top-0 z-40 border-b border-white/10 bg-brand text-white">
    <div class="app-container flex h-16 items-center gap-2">
        <a href="{{ locale_path('/') }}" class="-ml-1 flex shrink-0 items-center gap-2.5 whitespace-nowrap rounded-lg px-1 py-1 text-[1.0625rem] font-bold tracking-[-0.02em] text-white">
            <x-ui.logo />
            <span>{{ __('ui.site_name') }}</span>
        </a>

        <nav class="ml-4 hidden items-center gap-0.5 lg:flex xl:ml-6" aria-label="{{ __('ui.nav.primary') }}">
            @foreach($primary as $item)
                <a href="{{ $item['url'] }}" @class([$navLink, 'bg-white/15 text-white' => $item['active'], 'text-white/80 hover:bg-white/10 hover:text-white' => ! $item['active']]) @if($item['active']) aria-current="page" @endif>{{ $item['label'] }}</a>
            @endforeach

            <div class="relative" x-data="{ open: false }" @click.outside="open = false" @keydown.escape="open = false">
                <button type="button" @click="open = !open" :aria-expanded="open.toString()" aria-haspopup="true" aria-controls="tools-menu" @class([$navLink, 'gap-1', 'bg-white/15 text-white' => $toolsActive, 'text-white/80 hover:bg-white/10 hover:text-white' => ! $toolsActive])>
                    {{ __('ui.nav.vat_tools') }}
                    <x-ui.icon name="chevron-down" class="size-3.5 transition-transform duration-150" x-bind:class="open && 'rotate-180'" />
                </button>

                <div id="tools-menu" x-cloak x-show="open" x-transition.opacity.duration.150ms class="absolute left-1/2 top-full z-50 mt-2 w-[26rem] -translate-x-1/2 rounded-2xl border border-line bg-surface p-2 text-ink shadow-floating">
                    <div class="grid grid-cols-2 gap-1">
                        @foreach($tools as $tool)
                            <a href="{{ $tool['url'] }}" @class(['group flex gap-3 rounded-xl p-3 transition-colors hover:bg-surface-subtle', 'bg-action-soft' => $tool['active']]) @if($tool['active']) aria-current="page" @endif>
                                <span class="mt-0.5 flex size-8 shrink-0 items-center justify-center rounded-lg bg-action-soft text-action">
                                    <x-ui.icon :name="$tool['icon']" class="size-4" />
                                </span>
                                <span class="min-w-0">
                                    <span class="block text-sm font-semibold text-ink">{{ $tool['label'] }}</span>
                                    <span class="mt-0.5 block text-xs leading-5 text-ink-muted">{{ $tool['description'] }}</span>
                                </span>
                            </a>
                        @endforeach
                    </div>
                    <a href="{{ locale_path('/tools') }}" class="mt-1 flex items-center justify-between rounded-xl bg-surface-subtle px-3 py-2.5 text-sm font-semibold text-ink transition-colors hover:bg-surface-muted">
                        {{ __('ui.nav.all_tools') }}
                        <x-ui.icon name="arrow-right" class="size-4 text-ink-muted" />
                    </a>
                </div>
            </div>

            <a href="{{ locale_path('/blog') }}" @class([$navLink, 'bg-white/15 text-white' => SiteNavigation::isActive('blog.*'), 'text-white/80 hover:bg-white/10 hover:text-white' => ! SiteNavigation::isActive('blog.*')]) @if(SiteNavigation::isActive('blog.*')) aria-current="page" @endif>{{ __('ui.nav.updates') }}</a>
        </nav>

        <div class="ml-auto flex items-center gap-1">
            <button type="button" @click="$store.palette.show()" class="hidden h-10 w-60 items-center gap-2.5 rounded-xl border border-white/15 bg-white/10 px-3 text-left text-sm text-white/75 transition-colors hover:bg-white/15 hover:text-white xl:flex" aria-label="{{ __('ui.nav.search') }}">
                <x-ui.icon name="search" class="size-4" />
                <span class="flex-1 truncate">{{ __('ui.nav.search_placeholder') }}</span>
                <kbd class="rounded-md border border-white/20 px-1.5 py-0.5 font-sans text-[0.6875rem] font-semibold text-white/70">⌘K</kbd>
            </button>
            <button type="button" @click="$store.palette.show()" class="inline-flex size-10 items-center justify-center rounded-lg text-white/85 transition-colors hover:bg-white/10 hover:text-white xl:hidden" aria-label="{{ __('ui.nav.search') }}">
                <x-ui.icon name="search" class="size-5" />
            </button>

            <x-theme-toggle class="hidden sm:inline-flex" />
            <x-language-switcher class="hidden lg:block" />

            <a href="https://github.com/eimkasp/eu-vat.info" target="_blank" rel="noopener noreferrer" class="hidden size-10 items-center justify-center rounded-lg text-white/80 transition-colors hover:bg-white/10 hover:text-white 2xl:inline-flex" aria-label="{{ __('ui.nav.github') }}">
                <x-ui.icon name="github" class="size-5" />
            </a>

            <button type="button" @click="menu = !menu" class="inline-flex size-10 items-center justify-center rounded-lg text-white transition-colors hover:bg-white/10 lg:hidden" aria-controls="mobile-navigation" :aria-expanded="menu.toString()" aria-label="{{ __('ui.nav.toggle_menu') }}">
                <x-ui.icon name="menu" class="size-6" x-show="!menu" />
                <x-ui.icon name="x" class="size-6" x-show="menu" x-cloak />
            </button>
        </div>
    </div>

    <nav id="mobile-navigation" x-cloak x-show="menu" x-transition.opacity.duration.150ms class="border-t border-white/10 bg-brand pb-4 lg:hidden" aria-label="{{ __('ui.nav.mobile') }}">
        <div class="app-container grid gap-1 pt-3">
            @foreach($primary as $item)
                <a href="{{ $item['url'] }}" @class(['flex min-h-11 items-center rounded-xl px-3 text-[0.9375rem] font-medium', 'bg-white/15 text-white' => $item['active'], 'text-white/85 hover:bg-white/10' => ! $item['active']]) @if($item['active']) aria-current="page" @endif>{{ $item['label'] }}</a>
            @endforeach
            <a href="{{ locale_path('/blog') }}" class="flex min-h-11 items-center rounded-xl px-3 text-[0.9375rem] font-medium text-white/85 hover:bg-white/10">{{ __('ui.nav.updates') }}</a>

            <p class="mt-3 px-3 text-xs font-semibold text-white/60">{{ __('ui.nav.vat_tools') }}</p>
            <div class="grid grid-cols-2 gap-1">
                @foreach($tools as $tool)
                    <a href="{{ $tool['url'] }}" @class(['flex min-h-11 items-center gap-2.5 rounded-xl px-3 text-sm font-medium', 'bg-white/15 text-white' => $tool['active'], 'text-white/85 hover:bg-white/10' => ! $tool['active']]) @if($tool['active']) aria-current="page" @endif>
                        <x-ui.icon :name="$tool['icon']" class="size-4 text-white/70" />
                        <span class="truncate">{{ $tool['label'] }}</span>
                    </a>
                @endforeach
            </div>

            <div class="mt-3 flex items-center justify-between gap-3 border-t border-white/10 px-1 pt-4">
                <x-language-switcher :mobile="true" />
                <x-theme-toggle :with-label="true" />
            </div>
        </div>
    </nav>
</header>

<x-announcement-bar />
