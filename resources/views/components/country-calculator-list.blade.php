@php
    $groupLabels = [
        'eu' => __('ui.calculator.groups.eu'),
        'other_europe' => __('ui.calculator.groups.other_europe'),
    ];
    $countryCount = $countries->flatten(1)->count();
@endphp

<details data-country-directory class="group border border-line bg-white">
    <summary class="flex min-h-14 cursor-pointer list-none items-center gap-3 px-5 py-3 text-left focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-action [&::-webkit-details-marker]:hidden">
        <span class="flex-1 font-bold text-ink">{{ __('ui.calculator.browse_all_country_calculators') }}</span>
        <span class="text-xs font-semibold tabular-nums text-ink-muted">{{ $countryCount }}</span>
        <svg class="h-4 w-4 shrink-0 text-ink-muted transition-transform duration-150 group-open:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m6 9 6 6 6-6" />
        </svg>
    </summary>

    <div class="border-t border-line px-4 py-5 sm:px-5">
        @foreach($groupLabels as $group => $label)
            @if(($countries[$group] ?? collect())->isNotEmpty())
                <section class="{{ ! $loop->first ? 'mt-6 border-t border-line pt-5' : '' }}" aria-labelledby="calculator-group-{{ $group }}">
                    <h3 id="calculator-group-{{ $group }}" class="text-xs font-semibold uppercase tracking-[0.14em] text-ink-muted">{{ $label }}</h3>
                    <div class="mt-3 grid grid-cols-1 gap-1 sm:grid-cols-2 xl:grid-cols-1 2xl:grid-cols-2">
                        @foreach($countries[$group] as $country)
                            <a
                                href="{{ route('vat-calculator.country', $country->slug) }}"
                                class="group/link flex min-h-11 items-center gap-2.5 rounded-md px-2 py-2 text-sm transition-colors duration-150 hover:bg-surface-subtle focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-1 focus-visible:outline-action"
                            >
                                <img src="https://flagcdn.com/h40/{{ strtolower($country->iso_code) }}.jpg" alt="" class="h-4 w-auto shrink-0 rounded-[2px] ring-1 ring-black/10" loading="lazy">
                                <span class="min-w-0 flex-1 truncate font-semibold text-ink group-hover/link:text-action">{{ $country->name }}</span>
                                <span class="shrink-0 tabular-nums text-ink-muted">{{ $country->standard_rate }}%</span>
                            </a>
                        @endforeach
                    </div>
                </section>
            @endif
        @endforeach
    </div>
</details>
