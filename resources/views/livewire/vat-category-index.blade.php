@php
    $baseUrl = app(\App\Support\Seo\SeoPolicy::class)->canonicalHost();
    $canonical = $baseUrl.locale_path('/vat-rates/categories');
@endphp

@section('seo')
    <x-seo-meta
        title="EU VAT Rates by Category — Verified Country Rules"
        description="Browse verified VAT category rules across EU countries, including rates, effective dates, coverage and source links."
        :url="$canonical">
        <script type="application/ld+json">{!! json_encode([
            '@@context' => 'https://schema.org',
            '@type' => 'CollectionPage',
            '@id' => $canonical.'#webpage',
            'name' => 'EU VAT rates by category',
            'url' => $canonical,
            'mainEntity' => [
                '@type' => 'ItemList',
                'itemListElement' => $categories->values()->map(fn (array $category, int $index) => [
                    '@type' => 'ListItem',
                    'position' => $index + 1,
                    'name' => $category['name'],
                    'url' => $baseUrl.'/vat-rates/categories/'.$category['slug'],
                ])->all(),
            ],
        ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG) !!}</script>
    </x-seo-meta>
@endsection

<div class="app-container pb-14 pt-8 sm:pt-12">
    <x-site-breadcrumbs :items="['VAT rate categories' => '']" />

    <header class="max-w-3xl border-b border-line pb-8">
        <p class="mb-3 text-sm font-semibold text-action">Verified category rules</p>
        <h1 class="text-3xl font-bold tracking-tight text-ink sm:text-4xl">EU VAT rates by category</h1>
        <p class="mt-4 max-w-2xl text-lg text-ink-muted">Compare published category-specific VAT rules only where country coverage and source verification meet our indexing standard.</p>
    </header>

    <div class="mt-8 divide-y divide-line border-y border-line">
        @foreach($categories as $category)
            <a href="{{ locale_path('/vat-rates/categories/'.$category['slug']) }}" class="grid gap-3 py-5 text-ink transition-colors hover:text-action sm:grid-cols-[minmax(0,1fr)_auto] sm:items-center">
                <span>
                    <strong class="block text-lg">{{ $category['name'] }}</strong>
                    <span class="mt-1 block text-sm text-ink-muted">{{ $category['country_count'] }} EU countries · {{ number_format($category['minimum_rate'], 2) }}–{{ number_format($category['maximum_rate'], 2) }}%</span>
                </span>
                <span class="text-sm font-semibold" aria-hidden="true">Compare rates →</span>
            </a>
        @endforeach
    </div>

    <p class="mt-8 max-w-3xl text-sm leading-6 text-ink-muted">Category treatment can depend on product definitions, transaction details and national law. Every published rule links to its recorded source and verification date.</p>
</div>
