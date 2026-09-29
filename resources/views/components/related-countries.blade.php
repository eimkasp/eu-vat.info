@props(['country'])

@php
    $relatedCountries = app(\App\Services\Seo\InternalLinkService::class)->relatedCalculatorCountries($country, 6);
@endphp

<ul class="divide-y divide-line">
    @foreach($relatedCountries as $related)
        <li>
            <a href="{{ locale_path('/vat-calculator/'.$related->slug) }}" class="group flex min-h-13 items-center gap-3 py-2.5">
                <x-ui.flag :iso="$related->iso_code" size="lg" class="h-5 w-[1.625rem]" />
                <span class="min-w-0 flex-1">
                    <span class="block truncate text-sm font-semibold text-ink group-hover:text-action">{{ $related->name }}</span>
                    <span class="block text-xs text-ink-muted">{{ $related->is_eu_member ? __('ui.calculator.scope.eu') : __('ui.calculator.scope.other_europe') }}</span>
                </span>
                <span class="tabular text-sm font-bold text-ink">{{ \App\Models\Country::formatRate($related->standard_rate) }}%</span>
            </a>
        </li>
    @endforeach
</ul>
