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

<div class="app-container pb-14 pt-8 sm:pt-12">
    <x-site-breadcrumbs :items="['VAT changes' => locale_path('/vat-changes'), $title => '']" />
    <header class="max-w-3xl border-b border-line pb-7"><h1 class="text-3xl font-bold tracking-tight text-ink sm:text-4xl">{{ $title }}</h1><p class="mt-4 text-lg text-ink-muted">{{ $description }}</p></header>

    <section class="mt-8 max-w-4xl" aria-label="{{ $title }}">
        <div class="divide-y divide-line border-y border-line">
            @forelse($changes as $change)
                <article class="py-5">
                    <div class="flex flex-wrap items-start justify-between gap-4">
                        <div>
                            <h2 class="text-lg font-bold text-ink">{{ $change->country->name }} {{ str_replace('_', ' ', $change->rate_type) }} VAT</h2>
                            <p class="mt-1 text-ink-muted">{{ number_format((float) $change->old_rate, 2) }}% → <strong class="text-ink">{{ number_format((float) $change->new_rate, 2) }}%</strong></p>
                            @if($change->description)<p class="mt-2 max-w-2xl text-sm text-ink-muted">{{ $change->description }}</p>@endif
                        </div>
                        <time class="text-sm font-semibold text-ink-muted" datetime="{{ $change->change_date->toDateString() }}">{{ $change->change_date->format('M j, Y') }}</time>
                    </div>
                    <a class="mt-3 inline-flex text-sm font-semibold text-action hover:underline" href="{{ locale_path('/vat-changes/'.$change->country->slug.'/'.$change->rate_type.'/'.$change->change_date->toDateString()) }}">View sourced change →</a>
                </article>
            @empty
                <p class="py-8 text-ink-muted">No confirmed upcoming VAT changes are recorded.</p>
            @endforelse
        </div>
    </section>
</div>
