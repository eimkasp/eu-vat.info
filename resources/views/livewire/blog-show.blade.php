@section('seo')
    <x-seo-meta
        :title="$post['title'].' | EU VAT Info'"
        :description="$post['description']"
        :url="url(locale_path('/blog/'.$post['slug']))"
        type="article">
        <script type="application/ld+json">
        {!! json_encode([
            '@context' => 'https://schema.org',
            '@type' => 'BlogPosting',
            'headline' => $post['title'],
            'description' => $post['description'],
            'datePublished' => $post['published_at']->toIso8601String(),
            'dateModified' => $post['updated_at']->toIso8601String(),
            'author' => [
                '@type' => 'Organization',
                'name' => $post['author'],
            ],
            'publisher' => [
                '@type' => 'Organization',
                'name' => __('ui.site_name'),
                'url' => url(locale_path('/')),
            ],
            'mainEntityOfPage' => url(locale_path('/blog/'.$post['slug'])),
            'citation' => collect($post['sources'])->pluck('url')->values()->all(),
        ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
        </script>
    </x-seo-meta>
@endsection

<div class="container pb-12">
    <x-breadcrumbs :items="['VAT updates' => locale_path('/blog'), $post['title'] => '']" />

    <div class="grid lg:grid-cols-[minmax(0,1fr)_360px] gap-6 items-start">
        <article class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl shadow-sm overflow-hidden">
            <header class="p-6 sm:p-8 border-b border-gray-100 dark:border-gray-700 bg-gradient-to-br from-blue-50 to-white dark:from-gray-900 dark:to-gray-800">
                <div class="flex flex-wrap items-center gap-2 text-xs text-gray-600 dark:text-gray-300 mb-4">
                    <span class="inline-flex rounded-full bg-blue-600 px-2.5 py-1 font-semibold text-white">{{ $post['category'] }}</span>
                    <span>Published {{ $post['published_at']->format('M d, Y') }}</span>
                    <span>Updated {{ $post['updated_at']->format('M d, Y') }}</span>
                    <span>{{ $post['reading_time'] }} min read</span>
                </div>
                <h1 class="text-3xl sm:text-5xl font-bold tracking-normal text-gray-950 dark:text-white mb-4">{{ $post['title'] }}</h1>
                <p class="text-lg text-gray-700 dark:text-gray-200 max-w-3xl">{{ $post['description'] }}</p>
                <div class="flex flex-wrap gap-2 mt-5">
                    @foreach($post['tags'] as $tag)
                        <span class="rounded-full bg-white/80 dark:bg-gray-700 px-2.5 py-1 text-xs font-medium text-gray-700 dark:text-gray-200 border border-gray-200 dark:border-gray-600">{{ $tag }}</span>
                    @endforeach
                </div>
            </header>

            <div class="p-6 sm:p-8">
                <div class="mb-8">
                    @livewire('vat-change-signup', ['source' => 'blog-'.$post['slug']])
                </div>

                <div class="blog-content">
                    {!! $html !!}
                </div>
            </div>
        </article>

        <aside class="space-y-4 lg:sticky lg:top-24">
            @livewire('vat-change-signup', ['source' => 'blog-sidebar', 'compact' => true])

            <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl shadow-sm p-5">
                <h2 class="text-base font-bold text-gray-900 dark:text-white mb-3">Official sources</h2>
                <ul class="space-y-3 text-sm">
                    @foreach($post['sources'] as $source)
                        <li>
                            <a href="{{ $source['url'] }}" target="_blank" rel="noopener noreferrer" class="text-blue-700 dark:text-blue-300 hover:underline">
                                {{ $source['title'] }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </aside>
    </div>
</div>
