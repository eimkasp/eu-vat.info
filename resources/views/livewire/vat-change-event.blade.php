@php
    $country = $change->country;
    $baseUrl = app(\App\Support\Seo\SeoPolicy::class)->canonicalHost();
    $canonical = $baseUrl.locale_path('/vat-changes/'.$country->slug.'/'.$change->rate_type.'/'.$change->change_date->toDateString());
    $headline = $country->name.' '.str_replace('_', ' ', $change->rate_type).' VAT rate changed from '.number_format((float) $change->old_rate, 2).'% to '.number_format((float) $change->new_rate, 2).'%';
@endphp

@section('seo')
    <x-seo-meta :title="$headline.' | EU VAT Info'" :description="$change->description ?: $headline" :url="$canonical" type="article">
        <script type="application/ld+json">{!! json_encode([
            '@context' => 'https://schema.org',
            '@graph' => [
                ['@type' => 'BreadcrumbList', '@id' => $canonical.'#breadcrumbs', 'itemListElement' => [
                    ['@type' => 'ListItem', 'position' => 1, 'name' => 'EU VAT Info', 'item' => $baseUrl.'/'],
                    ['@type' => 'ListItem', 'position' => 2, 'name' => 'VAT changes', 'item' => $baseUrl.locale_path('/vat-changes')],
                    ['@type' => 'ListItem', 'position' => 3, 'name' => $country->name, 'item' => $canonical],
                ]],
                ['@type' => 'Article', '@id' => $canonical.'#article', 'headline' => $headline, 'description' => $change->description ?: $headline, 'datePublished' => ($change->announced_date ?? $change->change_date)->toIso8601String(), 'dateModified' => $change->updated_at->toIso8601String(), 'mainEntityOfPage' => $canonical, 'author' => ['@type' => 'Organization', 'name' => 'EU VAT Info'], 'citation' => array_values(array_filter([$change->source_url, $change->official_document]))],
            ],
        ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}</script>
    </x-seo-meta>
@endsection

<article class="container pb-14 pt-8 sm:pt-12">
    <x-breadcrumbs :items="['VAT changes' => locale_path('/vat-changes'), $country->name => locale_path('/vat-rates/'.$country->slug.'/history'), $change->change_date->format('M j, Y') => '']" />

    <header class="max-w-4xl border-b border-line pb-8">
        <p class="text-sm font-semibold text-action">Effective {{ $change->change_date->format('F j, Y') }}</p>
        <h1 class="mt-3 text-3xl font-bold tracking-tight text-ink sm:text-4xl">{{ $headline }}</h1>
        @if($change->description)<p class="mt-4 max-w-3xl text-lg text-ink-muted">{{ $change->description }}</p>@endif
    </header>

    <div class="mt-8 grid gap-10 lg:grid-cols-[minmax(0,1fr)_320px]">
        <div>
            <section class="grid grid-cols-[1fr_auto_1fr] items-center gap-4 border-y border-line py-6 text-center">
                <div><span class="block text-sm font-semibold text-ink-muted">Previous rate</span><strong class="mt-1 block text-3xl tabular-nums text-ink">{{ number_format((float) $change->old_rate, 2) }}%</strong></div>
                <span class="text-2xl text-ink-muted" aria-hidden="true">→</span>
                <div><span class="block text-sm font-semibold text-ink-muted">New rate</span><strong class="mt-1 block text-3xl tabular-nums text-action-deep">{{ number_format((float) $change->new_rate, 2) }}%</strong></div>
            </section>

            @if($change->change_reason)
                <section class="mt-8"><h2 class="text-2xl font-bold text-ink">Reason for the change</h2><p class="mt-3 text-ink-muted">{{ $change->change_reason }}</p></section>
            @endif

            <section class="mt-8"><h2 class="text-2xl font-bold text-ink">Dates and scope</h2><dl class="mt-4 divide-y divide-line border-y border-line text-sm"><div class="flex justify-between gap-4 py-3"><dt class="text-ink-muted">Rate type</dt><dd class="font-semibold text-ink">{{ ucfirst(str_replace('_', ' ', $change->rate_type)) }}</dd></div><div class="flex justify-between gap-4 py-3"><dt class="text-ink-muted">Effective date</dt><dd class="font-semibold text-ink">{{ $change->change_date->format('F j, Y') }}</dd></div>@if($change->announced_date)<div class="flex justify-between gap-4 py-3"><dt class="text-ink-muted">Announced</dt><dd class="font-semibold text-ink">{{ $change->announced_date->format('F j, Y') }}</dd></div>@endif</dl></section>
        </div>

        <aside class="space-y-4">
            @if($change->source_url)<a class="app-button-primary w-full" href="{{ $change->source_url }}" rel="noopener noreferrer">{{ $change->source ?: 'Open official source' }}</a>@endif
            <a class="app-button-secondary w-full" href="{{ locale_path('/vat-rates/'.$country->slug.'/history') }}">{{ $country->name }} VAT history</a>
            <a class="app-button-secondary w-full" href="{{ locale_path('/vat-calculator/'.$country->slug) }}">Current VAT calculator</a>
        </aside>
    </div>
</article>
