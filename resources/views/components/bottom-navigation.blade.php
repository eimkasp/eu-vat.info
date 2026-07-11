<nav class="fixed inset-x-0 bottom-0 z-30 border-t border-line bg-white/95 pb-[env(safe-area-inset-bottom)] md:hidden" aria-label="Mobile navigation">
    <div class="mx-auto grid h-[4.5rem] max-w-lg grid-cols-3">
        <a href="{{ locale_path('/') }}" 
           @if(request()->routeIs('home')) aria-current="page" @endif
           class="group inline-flex min-h-11 flex-col items-center justify-center gap-1 px-4 text-sm font-medium transition-colors hover:bg-surface-subtle {{ request()->routeIs('home') ? 'text-action' : 'text-ink-muted' }}">
            <svg class="w-5 h-5 mb-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8v10a1 1 0 0 0 1 1h4v-5a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v5h4a1 1 0 0 0 1-1V8M1 10l9-9 9 9"/>
            </svg>
            <span>{{ __('ui.bottom_nav.home') }}</span>
        </a>
        
        <a href="{{ locale_path('/vat-calculator') }}" 
           @if(request()->routeIs('vat-calculator*')) aria-current="page" @endif
           class="group inline-flex min-h-11 flex-col items-center justify-center gap-1 px-4 text-sm font-medium transition-colors hover:bg-surface-subtle {{ request()->routeIs('vat-calculator*') ? 'text-action' : 'text-ink-muted' }}">
            <svg class="w-5 h-5 mb-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 1v3m5-3v3m5-3v3M1 7h18M5 11h10M2 3h16a1 1 0 0 1 1 1v14a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1Z"/>
            </svg>
            <span>{{ __('ui.bottom_nav.calculator') }}</span>
        </a>
        
        <a href="{{ locale_path('/vat-map') }}" 
           @if(request()->routeIs('vat-map')) aria-current="page" @endif
           class="group inline-flex min-h-11 flex-col items-center justify-center gap-1 px-4 text-sm font-medium transition-colors hover:bg-surface-subtle {{ request()->routeIs('vat-map') ? 'text-action' : 'text-ink-muted' }}">
            <svg class="w-5 h-5 mb-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15a6 6 0 1 0 0-12 6 6 0 0 0 0 12Zm0 0v3M9.5 9.5a2.5 2.5 0 1 0 5 0 2.5 2.5 0 0 0-5 0Z"/>
            </svg>
            <span>{{ __('ui.bottom_nav.map') }}</span>
        </a>
        
    </div>
</nav>
