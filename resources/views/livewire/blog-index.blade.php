@section('seo')
    <x-seo-meta
        title="EU VAT Updates and Guides"
        description="Research-backed VAT updates, EU VAT changes, and practical compliance guides for businesses tracking European VAT rates."
        :url="url(locale_path('/blog'))">
        <script type="application/ld+json">
        {
            "@context": "https://schema.org",
            "@type": "Blog",
            "name": "EU VAT Updates and Guides",
            "description": "Research-backed VAT updates and European VAT compliance guides.",
            "url": "{{ url(locale_path('/blog')) }}",
            "publisher": {
                "@type": "Organization",
                "name": "{{ __('ui.site_name') }}",
                "url": "{{ url(locale_path('/')) }}"
            }
        }
        </script>
    </x-seo-meta>
@endsection

<div class="container pb-12">
    <x-breadcrumbs :items="['VAT updates' => '']" />

    <section class="mb-8">
        <p class="text-sm font-semibold uppercase tracking-wide text-blue-700 mb-2">EU VAT updates</p>
        <h1 class="text-3xl sm:text-4xl font-bold text-gray-900 dark:text-white mb-3">Research-backed VAT changes and guides</h1>
        <p class="max-w-3xl text-gray-600 dark:text-gray-300">
            Track confirmed VAT rate changes, EU VAT reforms, and practical compliance updates from official sources.
        </p>
    </section>

    <div class="grid lg:grid-cols-[1fr_360px] gap-6 items-start">
        <section class="space-y-4">
            @forelse($posts as $post)
                <article class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl shadow-sm p-5">
                    <div class="flex flex-wrap items-center gap-2 text-xs text-gray-500 dark:text-gray-400 mb-3">
                        <span class="inline-flex rounded-full bg-blue-50 px-2.5 py-1 font-semibold text-blue-700 dark:bg-blue-900/30 dark:text-blue-200">{{ $post['category'] }}</span>
                        <span>{{ $post['published_at']->format('M d, Y') }}</span>
                        <span>{{ $post['reading_time'] }} min read</span>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">
                        <a href="{{ locale_path('/blog/'.$post['slug']) }}" class="hover:text-blue-700 dark:hover:text-blue-300">
                            {{ $post['title'] }}
                        </a>
                    </h2>
                    <p class="text-gray-600 dark:text-gray-300 mb-4">{{ $post['description'] }}</p>
                    <div class="flex flex-wrap gap-2 mb-4">
                        @foreach($post['tags'] as $tag)
                            <span class="rounded-full bg-gray-100 dark:bg-gray-700 px-2.5 py-1 text-xs font-medium text-gray-600 dark:text-gray-300">{{ $tag }}</span>
                        @endforeach
                    </div>
                    <a href="{{ locale_path('/blog/'.$post['slug']) }}" class="inline-flex items-center text-sm font-semibold text-blue-700 dark:text-blue-300 hover:underline">
                        Read guide
                        <span aria-hidden="true" class="ml-1">-></span>
                    </a>
                </article>
            @empty
                <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl p-8 text-center text-gray-500 dark:text-gray-400">
                    No VAT updates have been published yet.
                </div>
            @endforelse
        </section>

        <aside class="lg:sticky lg:top-24">
            @livewire('vat-change-signup', ['source' => 'blog-index', 'compact' => true])
        </aside>
    </div>
</div>
