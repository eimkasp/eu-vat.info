@php
    $baseUrl = app(\App\Support\Seo\SeoPolicy::class)->canonicalHost();
    $path = '/compare/'.$leftCountry->slug.'-vs-'.$rightCountry->slug.'-vat';
    $canonical = $baseUrl.locale_path($path);
    $title = $leftCountry->name.' vs '.$rightCountry->name.' VAT rates';
@endphp

@section('seo')
    <x-seo-meta
        :title="$title.' — Rates, Calculators and History'"
        :description="'Compare '.$leftCountry->name.' and '.$rightCountry->name.' VAT rates, reduced rates, currencies, VIES availability and historical changes.'"
        :url="$canonical">
        <script type="application/ld+json">{!! json_encode([
            '@context' => 'https://schema.org',
            '@type' => 'WebPage',
            '@id' => $canonical.'#webpage',
            'name' => $title,
            'url' => $canonical,
            'about' => [
                ['@type' => 'Country', 'name' => $leftCountry->name],
                ['@type' => 'Country', 'name' => $rightCountry->name],
            ],
        ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}</script>
    </x-seo-meta>
@endsection

<div class="container pb-14 pt-8 sm:pt-12">
    <x-breadcrumbs :items="['EU VAT rates' => locale_path('/'), $title => '']" />
    <header class="max-w-4xl border-b border-line pb-8">
        <p class="text-sm font-semibold text-action">Country comparison</p>
        <h1 class="mt-3 text-3xl font-bold tracking-tight text-ink sm:text-4xl">{{ $title }}</h1>
        <p class="mt-4 max-w-3xl text-lg text-ink-muted">Compare current VAT structures and continue into each country’s calculator, validation guide and recorded history.</p>
    </header>

    <div class="mt-8 overflow-x-auto border-y border-line">
        <table class="w-full min-w-[640px] text-left">
            <thead class="bg-surface-subtle"><tr><th class="px-5 py-4 text-sm text-ink-muted">Measure</th>@foreach([$leftCountry, $rightCountry] as $country)<th class="px-5 py-4"><span class="flex items-center gap-2"><img src="https://flagcdn.com/h40/{{ strtolower($country->iso_code) }}.jpg" alt="{{ $country->name }} flag" class="h-5 w-7 rounded-sm object-cover"><span>{{ $country->name }}</span></span></th>@endforeach</tr></thead>
            <tbody class="divide-y divide-line">
                <tr><th class="px-5 py-4 text-sm font-semibold text-ink-muted">Standard rate</th><td class="px-5 py-4 text-2xl font-bold tabular-nums text-ink">{{ number_format((float) $leftCountry->standard_rate, 2) }}%</td><td class="px-5 py-4 text-2xl font-bold tabular-nums text-ink">{{ number_format((float) $rightCountry->standard_rate, 2) }}%</td></tr>
                <tr><th class="px-5 py-4 text-sm font-semibold text-ink-muted">Reduced rate</th><td class="px-5 py-4 font-semibold text-ink">{{ $leftCountry->reduced_rate ? $leftCountry->reduced_rate.'%' : 'Not recorded' }}</td><td class="px-5 py-4 font-semibold text-ink">{{ $rightCountry->reduced_rate ? $rightCountry->reduced_rate.'%' : 'Not recorded' }}</td></tr>
                <tr><th class="px-5 py-4 text-sm font-semibold text-ink-muted">Currency</th><td class="px-5 py-4 text-ink">{{ $leftCountry->currency_code ?: 'EUR' }}</td><td class="px-5 py-4 text-ink">{{ $rightCountry->currency_code ?: 'EUR' }}</td></tr>
                <tr><th class="px-5 py-4 text-sm font-semibold text-ink-muted">VIES validation</th><td class="px-5 py-4 text-ink">{{ $leftCountry->vies_available ? 'Available' : 'Not recorded' }}</td><td class="px-5 py-4 text-ink">{{ $rightCountry->vies_available ? 'Available' : 'Not recorded' }}</td></tr>
                <tr><th class="px-5 py-4 text-sm font-semibold text-ink-muted">Recorded changes</th><td class="px-5 py-4 text-ink">{{ $leftChanges }}</td><td class="px-5 py-4 text-ink">{{ $rightChanges }}</td></tr>
            </tbody>
        </table>
    </div>

    <div class="mt-8 grid gap-5 md:grid-cols-2">
        @foreach([$leftCountry, $rightCountry] as $country)
            <section class="app-surface p-5">
                <h2 class="text-xl font-bold text-ink">Explore {{ $country->name }}</h2>
                <div class="mt-4 flex flex-wrap gap-3 text-sm font-semibold">
                    <a class="text-action hover:underline" href="{{ locale_path('/vat-calculator/'.$country->slug) }}">VAT calculator</a>
                    @if($country->hasVatHistory())
                    <a class="text-action hover:underline" href="{{ locale_path('/vat-rates/'.$country->slug.'/history') }}">Rate history</a>
                    @endif
                    <a class="text-action hover:underline" href="{{ locale_path('/vat-number-validator/'.$country->slug) }}">VAT validator</a>
                </div>
            </section>
        @endforeach
    </div>

    <p class="mt-8 max-w-3xl text-sm text-ink-muted">VAT treatment depends on the transaction, customer status and goods or services supplied. Use this comparison as a rate reference and verify the applicable rule with the relevant authority.</p>
</div>
