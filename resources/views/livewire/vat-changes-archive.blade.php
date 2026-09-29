@use('App\Models\Country')

@php
    $baseUrl = app(\App\Support\Seo\SeoPolicy::class)->canonicalHost();
    $path = $upcoming ? '/vat-changes/upcoming' : '/vat-changes/year/'.$year;
    $canonical = $baseUrl.locale_path($path);
    $title = $upcoming ? 'Upcoming EU VAT changes' : 'VAT changes in '.$year;
    $description = $upcoming ? 'Confirmed future VAT rate changes across EU member states, with effective dates and official sources.' : 'Recorded EU VAT rate changes in '.$year.', including before-and-after rates, effective dates and country history.';
@endphp

@section('seo')
    <x-seo-meta :title="$title.' | EU VAT Info'" :description="$description" :url="$canonical" />
@endsection

<div>
    <x-page-header :title="$title" :description="$description" eyebrow="VAT rate changes" :breadcrumbs="['VAT rate changes' => locale_path('/vat-changes'), $title => '']">
        <x-slot:actions>
            <a href="{{ locale_path('/vat-changes') }}" class="app-button-secondary">
                <x-ui.icon name="history" class="size-4" />
                All VAT rate changes
            </a>
        </x-slot:actions>
    </x-page-header>

    <div class="app-container py-8 sm:py-10">
        <section class="app-surface overflow-hidden" aria-labelledby="archive-heading">
            <div class="flex flex-wrap items-center justify-between gap-3 border-b border-line px-5 py-4 sm:px-6">
                <h2 id="archive-heading" class="text-lg font-bold text-ink">{{ $upcoming ? 'Scheduled changes' : 'Recorded changes' }}</h2>
                <p class="text-sm text-ink-muted">{{ $changes->count() }} {{ Str::plural('change', $changes->count()) }}</p>
            </div>

            @if($changes->isEmpty())
                <p class="px-5 py-10 text-center text-sm text-ink-muted sm:px-6">No confirmed upcoming VAT changes are recorded.</p>
            @else
                <ol class="divide-y divide-line">
                    @foreach($changes as $change)
                        @php
                            $delta = (float) $change->new_rate - (float) $change->old_rate;
                            $up = $delta > 0;
                            $eventUrl = locale_path('/vat-changes/'.$change->country->slug.'/'.$change->rate_type.'/'.$change->change_date->toDateString());
                        @endphp
                        <li class="flex flex-wrap items-center gap-x-4 gap-y-2 px-5 py-4 sm:flex-nowrap sm:px-6">
                            <time class="tabular w-24 shrink-0 text-sm text-ink-muted" datetime="{{ $change->change_date->toDateString() }}">{{ $change->change_date->format('j M Y') }}</time>
                            <div class="flex min-w-0 flex-1 items-center gap-3">
                                <x-ui.flag :iso="$change->country->iso_code" size="lg" class="h-5 w-[1.625rem]" />
                                <div class="min-w-0">
                                    <h3><a class="font-semibold text-ink hover:text-action hover:underline" href="{{ $eventUrl }}">{{ $change->country->name }} {{ str_replace('_', '-', $change->rate_type) }} VAT</a></h3>
                                    @if($change->editorialDescription())
                                        <p class="mt-0.5 text-xs leading-5 text-ink-muted">{{ $change->editorialDescription() }}</p>
                                    @endif
                                </div>
                            </div>
                            <div class="flex shrink-0 items-center gap-3">
                                <span class="tabular text-sm text-ink-muted">
                                    {{ Country::formatRate($change->old_rate) }}%
                                    <x-ui.icon name="arrow-right" class="inline size-3.5 align-[-2px] text-ink-quiet" />
                                    <span class="font-bold text-ink">{{ Country::formatRate($change->new_rate) }}%</span>
                                </span>
                                @if($delta != 0)
                                    <span @class(['tabular inline-flex min-w-16 items-center justify-end gap-0.5 text-xs font-semibold', 'text-danger' => $up, 'text-success' => ! $up])>
                                        <x-ui.icon :name="$up ? 'trending-up' : 'trending-down'" class="size-3.5" />
                                        <span class="sr-only">{{ $up ? 'Increase' : 'Decrease' }}</span>
                                        {{ $up ? '+' : '−' }}{{ Country::formatRate(abs($delta)) }} pp
                                    </span>
                                @endif
                                <a href="{{ $eventUrl }}" class="app-button-ghost size-9 min-h-9 p-0" aria-label="View the sourced {{ $change->country->name }} change">
                                    <x-ui.icon name="chevron-right" class="size-4" />
                                </a>
                            </div>
                        </li>
                    @endforeach
                </ol>
            @endif
        </section>
    </div>
</div>
