<header x-data="{ mobileMenuOpen: false }" class="bg-[#003399] text-white sticky top-0 z-[99] shadow-xl">
    <div class="container !py-4 !px-4 sm:!px-6">
        <div class="flex justify-between items-center">
            {{-- Logo --}}
            <div class="flex items-center">
                <a class="font-extrabold text-xl" href="{{ locale_path('/') }}">
                    {{ __('ui.site_name') }}
                </a>
            </div>

            {{-- Hide mobile menu button on md and up --}}
            <button @click="mobileMenuOpen = !mobileMenuOpen" class="md:hidden" aria-label="Toggle navigation menu">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path x-show="!mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    <path x-show="mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>

            {{-- Desktop navigation --}}
            <nav class="hidden md:flex items-center gap-6">
                <a href="{{ locale_path('/') }}" title="{{ __('ui.nav.all_countries') }}" class="hover:text-blue-200 focus-visible:outline focus-visible:outline-2 focus-visible:outline-white focus-visible:outline-offset-2 rounded transition-colors" @if(request()->routeIs('home')) aria-current="page" @endif>{{ __('ui.nav.all_countries') }}</a>
                <a href="{{ locale_path('/vat-calculator') }}" class="hover:text-blue-200 focus-visible:outline focus-visible:outline-2 focus-visible:outline-white focus-visible:outline-offset-2 rounded transition-colors" @if(request()->routeIs('vat-calculator*')) aria-current="page" @endif>{{ __('ui.nav.vat_calculator') }}</a>

                {{-- VAT Tools dropdown --}}
                <div class="relative" x-data="{ open: false }" @click.outside="open = false" @keydown.escape.window="open = false">
                    <button @click="open = !open"
                            :aria-expanded="open.toString()"
                            aria-haspopup="true"
                            class="flex items-center gap-1 hover:text-blue-200 focus-visible:outline focus-visible:outline-2 focus-visible:outline-white focus-visible:outline-offset-2 rounded transition-colors {{ request()->routeIs('tools', 'vat-map', 'vat-changes', 'vies-validator*', 'widget.*') ? 'text-blue-200' : '' }}">
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
                         class="absolute left-1/2 -translate-x-1/2 top-full mt-2 w-52 bg-white rounded-xl shadow-xl border border-gray-100 py-1.5 z-50"
                         style="display:none;">
                        <a href="{{ locale_path('/tools') }}" class="flex items-center gap-2.5 px-4 py-2.5 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-700 transition-colors font-semibold border-b border-gray-100 mb-1">
                            <svg class="w-4 h-4 text-blue-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                            All VAT Tools
                        </a>
                        <a href="{{ route('widget.embed') }}" class="flex items-center gap-2.5 px-4 py-2.5 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-700 transition-colors">
                            <svg class="w-4 h-4 text-indigo-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"/></svg>
                            {{ __('ui.nav.vat_widget') }}
                        </a>
                        <a href="{{ locale_path('/vat-map') }}" class="flex items-center gap-2.5 px-4 py-2.5 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-700 transition-colors" @if(request()->routeIs('vat-map')) aria-current="page" @endif>
                            <svg class="w-4 h-4 text-green-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/></svg>
                            {{ __('ui.nav.vat_map') }}
                        </a>
                        <a href="{{ locale_path('/vat-number-validator') }}" class="flex items-center gap-2.5 px-4 py-2.5 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-700 transition-colors" @if(request()->routeIs('vies-validator*')) aria-current="page" @endif>
                            <svg class="w-4 h-4 text-emerald-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            {{ __('ui.nav.vat_number_validator') }}
                        </a>
                        <a href="{{ locale_path('/vat-changes') }}" class="flex items-center gap-2.5 px-4 py-2.5 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-700 transition-colors" @if(request()->routeIs('vat-changes')) aria-current="page" @endif>
                            <svg class="w-4 h-4 text-amber-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            {{ __('ui.nav.vat_history') }}
                        </a>
                    </div>
                </div>

                <a href="https://github.com/eimkasp/eu-vat.info" target="_blank" class="w-6">
                    @svg('feathericon-github')
                </a>
                <x-language-switcher />
            </nav>
        </div>

        {{-- Mobile dropdown menu - hide on md and up --}}
        <nav x-cloak x-show="mobileMenuOpen" 
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 -translate-y-2"
             x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100 translate-y-0"
             x-transition:leave-end="opacity-0 -translate-y-2"
             class="md:hidden mt-4 space-y-3">
            <a href="{{ locale_path('/') }}" class="block py-2" title="{{ __('ui.nav.all_countries') }}">{{ __('ui.nav.all_countries') }}</a>
            <a href="{{ locale_path('/vat-calculator') }}" class="block py-2">{{ __('ui.nav.vat_calculator') }} 💶</a>
            <div class="border-t border-white/20 pt-2 pb-1">
                <p class="text-xs font-semibold text-blue-200 uppercase tracking-wider mb-2">{{ __('ui.nav.vat_tools') }}</p>
                <a href="{{ route('widget.embed') }}" class="block py-2 pl-2">{{ __('ui.nav.vat_widget') }}</a>
                <a href="{{ locale_path('/vat-map') }}" class="block py-2 pl-2">{{ __('ui.nav.vat_map') }} 🌍</a>
                <a href="{{ locale_path('/vat-number-validator') }}" class="block py-2 pl-2">{{ __('ui.nav.vat_number_validator') }}</a>
                <a href="{{ locale_path('/vat-changes') }}" class="block py-2 pl-2">{{ __('ui.nav.vat_history') }} 📊</a>
            </div>
            <a href="https://github.com/eimkasp/eu-vat.info" target="_blank" class="block py-2">
                GitHub @svg('feathericon-github', 'inline-block w-5 h-5 ml-1')
            </a>
            <div class="py-2">
                <x-language-switcher :mobile="true" />
            </div>
        </nav>
    </div>
</header>

{{-- Announcement bar --}}
<x-announcement-bar />

<x-bottom-navigation />
