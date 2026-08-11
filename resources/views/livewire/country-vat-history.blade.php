@php
    $baseUrl = app(\App\Support\Seo\SeoPolicy::class)->canonicalHost();
    $canonical = $baseUrl.locale_path('/vat-rates/'.$country->slug.'/history');
@endphp

@section('seo')
    <x-seo-meta
        :title="$country->name.' VAT Rate History — Changes and Effective Dates'"
        :description="'Review '.$country->name.' VAT rate history, including effective dates, previous rates, current rates and source-backed tax changes.'"
        :url="$canonical">
        <script type="application/ld+json">{!! json_encode([
            '@context' => 'https://schema.org',
            '@type' => 'Dataset',
            '@id' => $canonical.'#dataset',
            'name' => $country->name.' VAT rate history',
            'description' => 'Historical VAT rates and recorded VAT rate changes for '.$country->name.'.',
            'url' => $canonical,
            'dateModified' => optional($changes->max('updated_at') ?? $rates->max('updated_at') ?? $country->updated_at)->toIso8601String(),
            'license' => 'https://creativecommons.org/licenses/by/4.0/',
            'isBasedOn' => $changes->pluck('source_url')->filter()->unique()->values()->all(),
        ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}</script>
    </x-seo-meta>
@endsection

<div class="container pb-14 pt-8 sm:pt-12">
    <x-site-breadcrumbs :items="['VAT calculator' => locale_path('/vat-calculator'), $country->name => locale_path('/vat-calculator/'.$country->slug), 'Rate history' => '']" />

    <header class="max-w-3xl border-b border-line pb-7">
        <div class="flex items-center gap-3">
            <img src="https://flagcdn.com/h40/{{ strtolower($country->iso_code) }}.jpg" alt="{{ $country->name }} flag" class="h-6 w-9 rounded-sm object-cover">
            <p class="text-sm font-semibold text-action">Historical VAT data</p>
        </div>
        <h1 class="mt-3 text-3xl font-bold tracking-tight text-ink sm:text-4xl">{{ $country->name }} VAT rate history</h1>
        <p class="mt-4 text-lg text-ink-muted">Current standard rate: <strong class="text-ink">{{ number_format((float) $country->standard_rate, 2) }}%</strong>. Review recorded rates, effective periods and source-backed changes.</p>
    </header>

    <div class="mt-8 grid gap-10 lg:grid-cols-[minmax(0,1fr)_320px]">
        <main>
            <section aria-labelledby="recorded-changes">
                <h2 id="recorded-changes" class="text-2xl font-bold text-ink">Recorded changes</h2>
                @if($changes->isEmpty())
                    <p class="mt-4 border-y border-line py-6 text-ink-muted">No individual rate-change events have been recorded yet.</p>
                @else
                    <div class="mt-4 divide-y divide-line border-y border-line">
                        @foreach($changes as $change)
                            <article class="py-5">
                                <div class="flex flex-wrap items-baseline justify-between gap-3">
                                    <h3 class="text-lg font-bold text-ink">{{ ucfirst(str_replace('_', ' ', $change->rate_type)) }} rate: {{ number_format((float) $change->old_rate, 2) }}% → {{ number_format((float) $change->new_rate, 2) }}%</h3>
                                    <time class="text-sm text-ink-muted" datetime="{{ $change->change_date->toDateString() }}">{{ $change->change_date->format('F j, Y') }}</time>
                                </div>
                                @if($change->description)<p class="mt-2 text-ink-muted">{{ $change->description }}</p>@endif
                                <div class="mt-3 flex flex-wrap gap-4 text-sm">
                                    <a class="font-semibold text-action hover:underline" href="{{ locale_path('/vat-changes/'.$country->slug.'/'.$change->rate_type.'/'.$change->change_date->toDateString()) }}">View change details →</a>
                                    @if($change->source_url)<a class="text-ink-muted hover:text-action hover:underline" href="{{ $change->source_url }}" rel="noopener noreferrer">Official source</a>@endif
                                </div>
                            </article>
                        @endforeach
                    </div>
                @endif
            </section>

            <section class="mt-10" aria-labelledby="rate-periods">
                <h2 id="rate-periods" class="text-2xl font-bold text-ink">Rate periods</h2>
                <div class="mt-4 overflow-x-auto border-y border-line">
                    <table class="w-full min-w-[560px] text-left text-sm">
                        <thead class="bg-surface-subtle text-ink-muted"><tr><th class="px-4 py-3">Rate type</th><th class="px-4 py-3 text-right">Rate</th><th class="px-4 py-3">Effective from</th><th class="px-4 py-3">Effective to</th></tr></thead>
                        <tbody class="divide-y divide-line">
                            @forelse($rates as $rate)
                                <tr><td class="px-4 py-3 font-semibold text-ink">{{ ucfirst(str_replace('_', ' ', $rate->type)) }}</td><td class="px-4 py-3 text-right font-bold tabular-nums">{{ number_format((float) $rate->rate, 2) }}%</td><td class="px-4 py-3">{{ $rate->effective_from->format('M j, Y') }}</td><td class="px-4 py-3">{{ $rate->effective_to?->format('M j, Y') ?? 'Current' }}</td></tr>
                            @empty
                                <tr><td colspan="4" class="px-4 py-6 text-center text-ink-muted">No historical rate periods are available.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </section>
        </main>

        <aside class="space-y-4">
            <a class="app-button-primary w-full" href="{{ locale_path('/vat-calculator/'.$country->slug) }}">Calculate {{ $country->name }} VAT</a>
            <a class="app-button-secondary w-full" href="{{ locale_path('/vat-number-validator/'.$country->slug) }}">Validate a VAT number</a>
            <div class="app-surface p-5 text-sm text-ink-muted"><strong class="block text-ink">Data note</strong><p class="mt-2">Effective dates and sources are shown where available. Check the linked authority before making compliance decisions.</p></div>
        </aside>
    </div>
</div>
