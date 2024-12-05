<header x-data="{ mobileMenuOpen: false }" class="bg-[#003399] text-white sticky top-0 z-[99] shadow-xl">
    <div class="container !py-4 !px-4 sm:!px-6">
        <div class="flex justify-between items-center">
            {{-- Logo --}}
            <div class="flex items-center">
                <a wire:navigate class="font-extrabold text-xl" href="/">
                    EU VAT Info
                </a>
            </div>

            {{-- Mobile menu button --}}
            <button @click="mobileMenuOpen = !mobileMenuOpen" class="sm:hidden">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path x-show="!mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    <path x-show="mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>

            {{-- Desktop navigation --}}
            <nav class="hidden sm:flex items-center gap-6">
                <a wire:navigate="/" href="/" title="EU VAT countries list">All Countries 🇪��</a>
                <a wire:navigate="/vat-calculator" href="/vat-calculator">VAT Calculator 💶</a>
                <a wire:navigate="{{ route('widget.embed')}}" href="{{ route('widget.embed')}}">VAT Widget</a>
                <a wire:navigate={{ route('vat-map') }} href="{{ route('vat-map')}}">VAT Map 🌍</a>
                <a href="https://github.com/eimkasp/eu-vat.info" target="_blank" class="w-6">
                    @svg('feathericon-github')
                </a>
            </nav>
        </div>

        {{-- Mobile navigation --}}
        <nav x-cloak x-show="mobileMenuOpen" 
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 -translate-y-2"
             x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100 translate-y-0"
             x-transition:leave-end="opacity-0 -translate-y-2"
             class="sm:hidden mt-4 space-y-3">
            <a wire:navigate="/" href="/" class="block py-2" title="EU VAT countries list">All Countries 🇪🇺</a>
            <a wire:navigate="/vat-calculator" href="/vat-calculator" class="block py-2">VAT Calculator 💶</a>
            <a wire:navigate="{{ route('widget.embed')}}" href="{{ route('widget.embed')}}" class="block py-2">VAT Widget</a>
            <a wire:navigate={{ route('vat-map') }} href="{{ route('vat-map')}}" class="block py-2">VAT Map 🌍</a>
            <a href="https://github.com/eimkasp/eu-vat.info" target="_blank" class="block py-2">
                GitHub @svg('feathericon-github', 'inline-block w-5 h-5 ml-1')
            </a>
        </nav>
    </div>
</header>

{{-- Announcement bar --}}
<x-announcement-bar />

