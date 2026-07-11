<div>
    @if(count($recentCountries) > 0)
    <div class="app-surface p-4 sm:p-5">
        <h2 class="mb-4 text-lg font-bold text-ink">Recently Viewed Countries</h2>
        <div class="grid grid-cols-2 gap-2">
            @foreach($recentCountries as $country)
            <a href="{{ locale_path('/vat-calculator/' . $country->slug) }}"
               class="flex min-h-11 items-center gap-2 rounded-lg p-2.5 transition-colors hover:bg-surface-subtle">
                <img src="https://flagcdn.com/h40/{{ strtolower($country->iso_code) }}.jpg"
                     alt="{{ $country->name }} flag"
                     class="h-5 w-7 shrink-0 rounded-sm object-cover">
                <span class="min-w-0 flex-1 truncate text-sm font-medium text-ink">{{ $country->name }}</span>
                <span class="text-sm font-semibold tabular-nums text-ink-muted sm:text-xs">{{ $country->standard_rate }}%</span>
            </a>
            @endforeach
        </div>
    </div>
    @endif
</div>
