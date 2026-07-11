@props(['country'])

@php
    $relatedCountries = app(\App\Services\Seo\InternalLinkService::class)->relatedCalculatorCountries($country, 6);
@endphp

<div class="divide-y divide-line border-y border-line">
    @foreach($relatedCountries as $related)
        <a
            href="{{ locale_path('/vat-calculator/' . $related->slug) }}"
            class="group flex min-h-14 items-center gap-3 py-2.5 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-action"
        >
            <img src="https://flagcdn.com/h40/{{ strtolower($related->iso_code) }}.jpg" alt="" class="h-5 w-auto shrink-0 rounded-[2px] ring-1 ring-black/10" loading="lazy">
            <span class="min-w-0 flex-1">
                <span class="block truncate text-sm font-semibold text-ink group-hover:text-action">{{ $related->name }}</span>
                <span class="block text-xs text-ink-muted">{{ $related->is_eu_member ? __('ui.calculator.scope.eu') : __('ui.calculator.scope.other_europe') }}</span>
            </span>
            <span class="shrink-0 text-sm font-bold tabular-nums text-ink">{{ $related->standard_rate }}%</span>
        </a>
    @endforeach
</div>
