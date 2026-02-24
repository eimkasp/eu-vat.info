@php
    $count = 1;
    if ($country->reduced_rate) $count++;
    if ($country->parking_rate) $count++;
    if ($country->super_reduced_rate) $count++;
    
    $gridCols = 'grid-cols-2';
    if ($count >= 3) {
        $gridCols = 'grid-cols-2 sm:grid-cols-3';
    }
@endphp

<div>
    <h3 class="text-base font-semibold leading-6 text-gray-900 mb-3">{{ __('ui.country_page.vat_rates') }} - {{ $country->name }}</h3>
    <dl class="grid {{ $gridCols }} gap-3">
        <div class="overflow-hidden rounded-lg bg-white p-3 shadow">
            <dt class="truncate text-xs font-medium text-gray-500">{{ __('ui.country_page.standard_rate') }}</dt>
            <dd class="mt-1 text-2xl font-semibold tracking-tight text-gray-900">
                {{ $country->standard_rate }}%
            </dd>
        </div>
        
        @if ($country->reduced_rate)
        <div class="overflow-hidden rounded-lg bg-white p-3 shadow">
            <dt class="truncate text-xs font-medium text-gray-500">{{ __('ui.country_page.reduced_rate') }}</dt>
            <dd class="mt-1 text-2xl font-semibold tracking-tight text-gray-900">
                {{ $country->reduced_rate }}%
            </dd>
        </div>
        @endif

        @if ($country->parking_rate)
            <div class="overflow-hidden rounded-lg bg-white p-3 shadow">
                <dt class="truncate text-xs font-medium text-gray-500">{{ __('ui.country_page.parking_rate') }}</dt>
                <dd class="mt-1 text-2xl font-semibold tracking-tight text-gray-900">
                    {{ $country->parking_rate }}%
                </dd>
            </div>
        @endif

        @if ($country->super_reduced_rate)
            <div class="overflow-hidden rounded-lg bg-white p-3 shadow">
                <dt class="truncate text-xs font-medium text-gray-500">{{ __('ui.country_page.super_reduced') }}</dt>
                <dd class="mt-1 text-2xl font-semibold tracking-tight text-gray-900">
                    {{ $country->super_reduced_rate }}%
                </dd>
            </div>
        @endif
    </dl>
</div>
