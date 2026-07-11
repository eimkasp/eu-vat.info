<header x-data="{ mobileMenuOpen: false }" class="sticky top-0 z-40 border-b border-white/15 bg-brand text-white">
    <div class="container !px-4 !py-2.5 sm:!px-6">
        <div class="flex justify-between items-center">
            {{-- Logo --}}
            <div class="flex items-center">
                <a class="flex min-h-11 items-center rounded-md text-lg font-bold tracking-[-0.02em] text-white transition-colors hover:text-blue-100" href="{{ locale_path('/') }}">
                    {{ __('ui.site_name') }}
                </a>
            </div>

            {{-- Hide mobile menu button on md and up --}}
            <button @click="mobileMenuOpen = !mobileMenuOpen"
                    class="inline-flex min-h-11 min-w-11 items-center justify-center rounded-lg text-white transition-colors hover:bg-white/10 md:hidden"
                    aria-label="Toggle navigation menu"
                    aria-controls="mobile-navigation"
                    :aria-expanded="mobileMenuOpen.toString()">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path x-show="!mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    <path x-show="mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>

            {{-- Desktop navigation --}}
            <nav class="hidden items-center gap-1 text-sm font-medium md:flex" aria-label="Primary navigation">
                <a href="{{ locale_path('/') }}" title="{{ __('ui.nav.all_countries') }}" class="inline-flex min-h-11 items-center rounded-lg px-3 transition-colors hover:bg-white/10 hover:text-white {{ request()->routeIs('home') ? 'bg-white/15 text-white' : 'text-blue-100' }}" @if(request()->routeIs('home')) aria-current="page" @endif>{{ __('ui.nav.all_countries') }}</a>
                <a href="{{ locale_path('/vat-calculator') }}" class="inline-flex min-h-11 items-center rounded-lg px-3 transition-colors hover:bg-white/10 hover:text-white {{ request()->routeIs('vat-calculator*') ? 'bg-white/15 text-white' : 'text-blue-100' }}" @if(request()->routeIs('vat-calculator*')) aria-current="page" @endif>{{ __('ui.nav.vat_calculator') }}</a>

                {{-- VAT Tools dropdown --}}
                <div class="relative" x-data="{ open: false }" @click.outside="open = false" @keydown.escape.window="open = false">
                    <button @click="open = !open"
                            :aria-expanded="open.toString()"
                            aria-haspopup="true"
                            class="flex min-h-11 items-center gap-1 rounded-lg px-3 transition-colors hover:bg-white/10 hover:text-white {{ request()->routeIs('tools', 'vat-map', 'vat-changes', 'vies-validator*', 'widget.*') ? 'bg-white/15 text-white' : 'text-blue-100' }}">
                        {{ __('ui.nav.vat_tools') }}
                        <svg class="w-3.5 h-3.5 transition-transform duration-200" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/></svg>
                    </button>

                    <div x-show="open" x-cloak
                         x-transition:enter="transition ease-out duration-150"
                         x-transition:enter-start="opacity-0 translate-y-1"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         x-transition:leave="transition ease-in duration-100"
                         x-transition:leave-start="opacity-100 translate-y-0"
                         x-transition:leave-end="opacity-0 translate-y-1"
                         class="absolute left-1/2 top-full z-50 mt-2 w-56 -translate-x-1/2 rounded-lg border border-line bg-white py-1.5 shadow-floating"
                         style="display:none;">
                        <a href="{{ locale_path('/tools') }}" class="mb-1 flex min-h-11 items-center gap-2.5 border-b border-line px-4 py-2.5 text-sm font-semibold text-ink transition-colors hover:bg-action-soft hover:text-action-deep">
                            <svg class="w-4 h-4 text-blue-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                            All VAT Tools
                        </a>
                        <a href="{{ route('widget.embed') }}" class="flex min-h-11 items-center gap-2.5 px-4 py-2.5 text-sm text-ink-muted transition-colors hover:bg-action-soft hover:text-action-deep">
                            <svg class="w-4 h-4 text-indigo-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"/></svg>
                            {{ __('ui.nav.vat_widget') }}
                        </a>
                        <a href="{{ locale_path('/vat-map') }}" class="flex min-h-11 items-center gap-2.5 px-4 py-2.5 text-sm text-ink-muted transition-colors hover:bg-action-soft hover:text-action-deep" @if(request()->routeIs('vat-map')) aria-current="page" @endif>
                            <svg class="w-4 h-4 text-green-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/></svg>
                            {{ __('ui.nav.vat_map') }}
                        </a>
                        <a href="{{ locale_path('/vat-number-validator') }}" class="flex min-h-11 items-center gap-2.5 px-4 py-2.5 text-sm text-ink-muted transition-colors hover:bg-action-soft hover:text-action-deep" @if(request()->routeIs('vies-validator*')) aria-current="page" @endif>
                            <svg class="w-4 h-4 text-emerald-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            {{ __('ui.nav.vat_number_validator') }}
                        </a>
                        <a href="{{ locale_path('/vat-changes') }}" class="flex min-h-11 items-center gap-2.5 px-4 py-2.5 text-sm text-ink-muted transition-colors hover:bg-action-soft hover:text-action-deep" @if(request()->routeIs('vat-changes')) aria-current="page" @endif>
                            <svg class="w-4 h-4 text-amber-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            {{ __('ui.nav.vat_history') }}
                        </a>
                    </div>
                </div>

                <a href="{{ locale_path('/blog') }}" class="inline-flex min-h-11 items-center rounded-lg px-3 transition-colors hover:bg-white/10 hover:text-white {{ request()->routeIs('blog.*') ? 'bg-white/15 text-white' : 'text-blue-100' }}" @if(request()->routeIs('blog.*')) aria-current="page" @endif>VAT updates</a>

                <a href="https://github.com/eimkasp/eu-vat.info" target="_blank" rel="noopener noreferrer" aria-label="EU VAT Info on GitHub" class="inline-flex min-h-11 min-w-11 items-center justify-center rounded-lg text-blue-100 transition-colors hover:bg-white/10 hover:text-white">
                    @svg('feathericon-github')
                </a>
                <x-language-switcher />
            </nav>
        </div>

        {{-- Mobile dropdown menu - hide on md and up --}}
        <nav id="mobile-navigation" x-cloak x-show="mobileMenuOpen"
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 -translate-y-2"
             x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100 translate-y-0"
             x-transition:leave-end="opacity-0 -translate-y-2"
             class="mt-2 border-t border-white/15 pb-3 pt-2 text-sm font-medium md:hidden">
            <a href="{{ locale_path('/') }}" class="flex min-h-11 items-center rounded-lg px-3 text-blue-50 transition-colors hover:bg-white/10" title="{{ __('ui.nav.all_countries') }}">{{ __('ui.nav.all_countries') }}</a>
            <a href="{{ locale_path('/vat-calculator') }}" class="flex min-h-11 items-center rounded-lg px-3 text-blue-50 transition-colors hover:bg-white/10">{{ __('ui.nav.vat_calculator') }}</a>
            <a href="{{ locale_path('/blog') }}" class="flex min-h-11 items-center rounded-lg px-3 text-blue-50 transition-colors hover:bg-white/10">VAT updates</a>
            <div class="mt-1 border-t border-white/15 pb-1 pt-2">
                <p class="mb-1 px-3 text-sm font-semibold text-blue-200">{{ __('ui.nav.vat_tools') }}</p>
                <a href="{{ route('widget.embed') }}" class="flex min-h-11 items-center rounded-lg px-3 text-blue-50 transition-colors hover:bg-white/10">{{ __('ui.nav.vat_widget') }}</a>
                <a href="{{ locale_path('/vat-map') }}" class="flex min-h-11 items-center rounded-lg px-3 text-blue-50 transition-colors hover:bg-white/10">{{ __('ui.nav.vat_map') }}</a>
                <a href="{{ locale_path('/vat-number-validator') }}" class="flex min-h-11 items-center rounded-lg px-3 text-blue-50 transition-colors hover:bg-white/10">{{ __('ui.nav.vat_number_validator') }}</a>
                <a href="{{ locale_path('/vat-changes') }}" class="flex min-h-11 items-center rounded-lg px-3 text-blue-50 transition-colors hover:bg-white/10">{{ __('ui.nav.vat_history') }}</a>
            </div>
            <a href="https://github.com/eimkasp/eu-vat.info" target="_blank" rel="noopener noreferrer" class="flex min-h-11 items-center rounded-lg px-3 text-blue-50 transition-colors hover:bg-white/10">
                GitHub @svg('feathericon-github', 'inline-block w-5 h-5 ml-1')
            </a>
            <div class="px-3 py-2">
                <x-language-switcher :mobile="true" />
            </div>
        </nav>
    </div>
</header>

{{-- Announcement bar --}}
<x-announcement-bar />

<x-bottom-navigation />
