<div>
    @if($countries->isNotEmpty())
        <section class="app-surface p-5" aria-labelledby="recent-countries-heading">
            <h2 id="recent-countries-heading" class="text-base font-bold text-ink">{{ __('ui.home_page.recently_viewed') }}</h2>
            <div class="mt-3 grid grid-cols-2 gap-1">
                @foreach($countries as $country)
                    <a href="{{ locale_path('/vat-calculator/'.$country->slug) }}" class="flex min-h-10 items-center gap-2 rounded-lg px-2 transition-colors hover:bg-surface-subtle">
                        <x-ui.flag :iso="$country->iso_code" size="sm" />
                        <span class="min-w-0 flex-1 truncate text-sm font-medium text-ink">{{ $country->name }}</span>
                        <span class="tabular text-xs font-semibold text-ink-muted">{{ \App\Models\Country::formatRate($country->standard_rate) }}%</span>
                    </a>
                @endforeach
            </div>
        </section>
    @endif
</div>
