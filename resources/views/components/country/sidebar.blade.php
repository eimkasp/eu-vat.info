@props(['country'])

<x-country-stats :country="$country" />

{{-- VAT Rates at a Glance --}}
<div class="mt-6">
    @php
        $rates = collect([
            ['label' => __('ui.country_page.standard_rate'), 'value' => $country->standard_rate, 'bg' => 'bg-blue-50 dark:bg-blue-900/20', 'border' => 'border-blue-200 dark:border-blue-800', 'label_color' => 'text-blue-600 dark:text-blue-400'],
            ['label' => __('ui.country_page.reduced_rate'), 'value' => $country->reduced_rate, 'bg' => 'bg-green-50 dark:bg-green-900/20', 'border' => 'border-green-200 dark:border-green-800', 'label_color' => 'text-green-600 dark:text-green-400'],
            ['label' => __('ui.country_page.super_reduced'), 'value' => $country->super_reduced_rate, 'bg' => 'bg-purple-50 dark:bg-purple-900/20', 'border' => 'border-purple-200 dark:border-purple-800', 'label_color' => 'text-purple-600 dark:text-purple-400'],
            ['label' => __('ui.country_page.parking_rate'), 'value' => $country->parking_rate, 'bg' => 'bg-amber-50 dark:bg-amber-900/20', 'border' => 'border-amber-200 dark:border-amber-800', 'label_color' => 'text-amber-600 dark:text-amber-400'],
        ])->filter(fn($r) => $r['value']);
    @endphp

    <h4 class="font-bold text-gray-900 dark:text-white mb-3">{{ __('ui.country_page.vat_rates') }}</h4>
    <div class="grid grid-cols-2 gap-2">
        @foreach($rates as $rate)
            <div class="{{ $rate['bg'] }} border {{ $rate['border'] }} rounded-lg p-3 text-center">
                <div class="text-[10px] font-semibold uppercase tracking-wider {{ $rate['label_color'] }} mb-0.5">{{ $rate['label'] }}</div>
                <div class="text-2xl font-extrabold text-gray-900 dark:text-white">{{ $rate['value'] }}%</div>
            </div>
        @endforeach
    </div>

</div>

<div class="mt-9 space-y-3 sm:mb-12 border-t pt-3">
    <h4 class="font-bold text-gray-900 dark:text-white mb-3">{{ __('ui.footer.vat_tools') }}</h4>

    <div>
        <a class="flex items-center gap-2 text-blue-600 hover:underline hover:text-blue-700 transition-colors" 
          
           href="{{ route('vat-calculator.country', $country->slug) }}">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
            </svg>
            {{ __('ui.country_page.vat_calculator') }}
        </a>
    </div>

    <div>
        <a class="flex items-center gap-2 text-blue-600 hover:underline hover:text-blue-700 transition-colors" 
          
           href="{{ locale_path('/vat-changes') }}">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            {{ __('ui.country_page.vat_history') }}
        </a>
    </div>

    <div>
        <a class="flex items-center gap-2 text-blue-600 hover:underline hover:text-blue-700 transition-colors" 
          
           href="/embed/{{ $country->slug }}">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path>
            </svg>
            {{ __('ui.footer.embed_widget') }}
        </a>
    </div>
</div>

<!-- Sidebar Banners -->
<x-banner-display position="country_sidebar" />
