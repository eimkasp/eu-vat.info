@php
    $baseUrl = app(\App\Support\Seo\SeoPolicy::class)->canonicalHost();
    $canonical = $baseUrl.locale_path('/vat-guides/'.$scenario);
@endphp

@section('seo')
    <x-seo-meta :title="$guide['title'].' | EU VAT Info'" :description="$guide['summary']" :url="$canonical" type="article">
        <script type="application/ld+json">{!! json_encode([
            '@context' => 'https://schema.org',
            '@graph' => [
                ['@type' => 'BreadcrumbList', '@id' => $canonical.'#breadcrumbs', 'itemListElement' => [
                    ['@type' => 'ListItem', 'position' => 1, 'name' => 'EU VAT Info', 'item' => $baseUrl.'/'],
                    ['@type' => 'ListItem', 'position' => 2, 'name' => 'VAT tools', 'item' => $baseUrl.locale_path('/tools')],
                    ['@type' => 'ListItem', 'position' => 3, 'name' => $guide['title'], 'item' => $canonical],
                ]],
                ['@type' => 'Article', '@id' => $canonical.'#article', 'headline' => $guide['title'], 'description' => $guide['summary'], 'mainEntityOfPage' => $canonical, 'author' => ['@type' => 'Organization', 'name' => 'EU VAT Info'], 'citation' => $guide['sources']],
            ],
        ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}</script>
    </x-seo-meta>
@endsection

<article class="container pb-14 pt-8 sm:pt-12">
    <x-breadcrumbs :items="['VAT tools' => locale_path('/tools'), $guide['title'] => '']" />

    <header class="max-w-4xl border-b border-line pb-8">
        <p class="text-sm font-semibold text-action">EU VAT scenario guide</p>
        <h1 class="mt-3 text-3xl font-bold tracking-tight text-ink sm:text-4xl">{{ $guide['title'] }}</h1>
        <p class="mt-4 max-w-3xl text-lg text-ink-muted">{{ $guide['summary'] }}</p>
    </header>

    <div class="mt-8 grid gap-10 lg:grid-cols-[minmax(0,1fr)_320px]">
        <div class="max-w-3xl">
            <section><h2 class="text-2xl font-bold text-ink">General rule</h2><p class="mt-3 text-ink-muted">{{ $guide['rule'] }}</p></section>
            <section class="mt-8"><h2 class="text-2xl font-bold text-ink">Important exceptions</h2><p class="mt-3 text-ink-muted">{{ $guide['exceptions'] }}</p></section>
            <section class="mt-8"><h2 class="text-2xl font-bold text-ink">Legal references</h2><ul class="mt-3 flex flex-wrap gap-2">@foreach($guide['legal_refs'] as $reference)<li class="rounded-full border border-line bg-surface-subtle px-3 py-1 text-sm font-semibold text-ink">{{ $reference }}</li>@endforeach</ul></section>
            <p class="mt-8 border-y border-line py-5 text-sm text-ink-muted">This guide summarizes the general EU framework. Classification, establishment, customer evidence, national implementation and special schemes can change the result. Confirm material transactions with the relevant tax authority or adviser.</p>
        </div>

        <aside class="app-surface p-5">
            <h2 class="text-lg font-bold text-ink">Official sources</h2>
            <ul class="mt-4 space-y-3 text-sm">@foreach($guide['sources'] as $source)<li><a class="font-semibold text-action hover:underline" href="{{ $source }}" rel="noopener noreferrer">European Commission guidance →</a></li>@endforeach</ul>
            <a class="app-button-primary mt-6 w-full" href="{{ locale_path('/tools') }}">Open VAT tools</a>
        </aside>
    </div>

    <section class="mt-12 border-t border-line pt-8">
        <h2 class="text-xl font-bold text-ink">Related VAT scenarios</h2>
        <div class="mt-4 flex flex-wrap gap-x-5 gap-y-3 text-sm font-semibold">@foreach(config('vat-scenarios') as $relatedSlug => $relatedGuide)@if($relatedSlug !== $scenario)<a class="text-action hover:underline" href="{{ locale_path('/vat-guides/'.$relatedSlug) }}">{{ $relatedGuide['title'] }} →</a>@endif @endforeach</div>
    </section>
</article>
