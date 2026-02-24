<div class="fixed bottom-0 left-0 z-50 w-full h-16 bg-white border-t border-gray-200 md:hidden">
    <div class="grid h-full max-w-lg grid-cols-3 mx-auto">
        <a wire:navigate href="{{ locale_path('/') }}" 
           class="inline-flex flex-col items-center justify-center px-5 hover:bg-gray-50 group {{ request()->routeIs('home') ? 'text-blue-600' : 'text-gray-600' }}">
            <svg class="w-5 h-5 mb-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8v10a1 1 0 0 0 1 1h4v-5a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v5h4a1 1 0 0 0 1-1V8M1 10l9-9 9 9"/>
            </svg>
            <span class="text-xs">{{ __('ui.bottom_nav.home') }}</span>
        </a>
        
        <a wire:navigate href="{{ locale_path('/vat-calculator') }}" 
           class="inline-flex flex-col items-center justify-center px-5 hover:bg-gray-50 group {{ request()->routeIs('vat-calculator*') ? 'text-blue-600' : 'text-gray-600' }}">
            <svg class="w-5 h-5 mb-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 1v3m5-3v3m5-3v3M1 7h18M5 11h10M2 3h16a1 1 0 0 1 1 1v14a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1Z"/>
            </svg>
            <span class="text-xs">{{ __('ui.bottom_nav.calculator') }}</span>
        </a>
        
        <a wire:navigate href="{{ locale_path('/vat-map') }}" 
           class="inline-flex flex-col items-center justify-center px-5 hover:bg-gray-50 group {{ request()->routeIs('vat-map') ? 'text-blue-600' : 'text-gray-600' }}">
            <svg class="w-5 h-5 mb-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15a6 6 0 1 0 0-12 6 6 0 0 0 0 12Zm0 0v3M9.5 9.5a2.5 2.5 0 1 0 5 0 2.5 2.5 0 0 0-5 0Z"/>
            </svg>
            <span class="text-xs">{{ __('ui.bottom_nav.map') }}</span>
        </a>
        
       
    </div>
</div>
