@section('seo')
    <x-seo-meta
        :title="__('ui.changelog.meta_title')"
        :description="__('ui.changelog.meta_desc')"
        :url="url(locale_path('/changelog'))">
        <script type="application/ld+json">
        {!! json_encode([
            '@context' => 'https://schema.org',
            '@type'    => 'BreadcrumbList',
            'itemListElement' => [
                ['@type' => 'ListItem', 'position' => 1, 'name' => __('ui.site_name'), 'item' => url('/')],
                ['@type' => 'ListItem', 'position' => 2, 'name' => __('ui.changelog.nav_label'), 'item' => url(locale_path('/changelog'))],
            ],
        ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
        </script>
        <script type="application/ld+json">
        {!! json_encode([
            '@context'    => 'https://schema.org',
            '@type'       => 'SoftwareApplication',
            'name'        => __('ui.site_name'),
            'url'         => url('/'),
            'applicationCategory' => 'FinanceApplication',
            'operatingSystem' => 'All',
            'offers' => ['@type' => 'Offer', 'price' => '0', 'priceCurrency' => 'EUR'],
            'softwareVersion' => $releases[0]['version'] ?? '1.0.0',
            'releaseNotes' => url(locale_path('/changelog')),
            'dateModified' => $releases[0]['date'] ?? now()->toDateString(),
        ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
        </script>
    </x-seo-meta>
@endsection

<div class="container py-10 max-w-4xl mx-auto">

    {{-- Breadcrumbs --}}
    <x-breadcrumbs :items="[__('ui.changelog.nav_label') => '']" />

    {{-- Header --}}
    <div class="mb-10">
        <h1 class="text-3xl sm:text-4xl font-extrabold text-gray-900 dark:text-white mb-3">
            {{ __('ui.changelog.heading') }}
        </h1>
        <p class="text-gray-500 dark:text-gray-400 text-base max-w-2xl">
            {{ __('ui.changelog.subheading') }}
        </p>
    </div>

    @if(empty($releases))
        <div class="text-gray-500 dark:text-gray-400 py-8 text-center">
            {{ __('ui.changelog.empty') }}
        </div>
    @else
        {{-- Releases timeline --}}
        <div class="space-y-12">
            @foreach($releases as $release)
                @php
                    $isUnreleased = $release['version'] === 'Unreleased';
                    $anchor = $release['slug'];
                @endphp
                <article id="{{ $anchor }}" class="relative">

                    {{-- Version header --}}
                    <div class="flex flex-wrap items-center gap-3 mb-4">
                        @if($isUnreleased)
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-amber-100 text-amber-800 dark:bg-amber-900/40 dark:text-amber-300 text-sm font-bold ring-1 ring-amber-200 dark:ring-amber-700">
                                <span class="w-2 h-2 rounded-full bg-amber-500 animate-pulse"></span>
                                {{ __('ui.changelog.unreleased') }}
                            </span>
                        @else
                            <a href="#{{ $anchor }}" class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-blue-600 text-white text-sm font-bold hover:bg-blue-700 transition-colors no-underline">
                                v{{ $release['version'] }}
                            </a>
                        @endif

                        @if($release['date'])
                            <time datetime="{{ $release['date'] }}" class="text-sm text-gray-400 dark:text-gray-500 tabular-nums">
                                {{ \Carbon\Carbon::parse($release['date'])->format('d M Y') }}
                            </time>
                        @endif

                        @if($release['subtitle'])
                            <span class="text-sm font-medium text-gray-600 dark:text-gray-300">
                                — {{ $release['subtitle'] }}
                            </span>
                        @endif
                    </div>

                    {{-- Groups --}}
                    @if(!empty($release['groups']))
                        <div class="border border-gray-100 dark:border-gray-700 rounded-xl overflow-hidden bg-white dark:bg-gray-800 shadow-sm">
                            @foreach($release['groups'] as $gi => $group)
                                @php
                                    $badge = match(strtolower($group['name'])) {
                                        'added'    => ['bg' => 'bg-green-100 text-green-800 dark:bg-green-900/40 dark:text-green-300',   'dot' => 'bg-green-500'],
                                        'fixed'    => ['bg' => 'bg-red-100 text-red-800 dark:bg-red-900/40 dark:text-red-300',           'dot' => 'bg-red-500'],
                                        'improved', 'changed' => ['bg' => 'bg-blue-100 text-blue-800 dark:bg-blue-900/40 dark:text-blue-300', 'dot' => 'bg-blue-500'],
                                        'security' => ['bg' => 'bg-orange-100 text-orange-800 dark:bg-orange-900/40 dark:text-orange-300', 'dot' => 'bg-orange-500'],
                                        'removed'  => ['bg' => 'bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-300',           'dot' => 'bg-gray-400'],
                                        default    => ['bg' => 'bg-indigo-100 text-indigo-800 dark:bg-indigo-900/40 dark:text-indigo-300', 'dot' => 'bg-indigo-500'],
                                    };
                                @endphp
                                <div class="{{ $gi > 0 ? 'border-t border-gray-100 dark:border-gray-700' : '' }} px-5 py-4">
                                    <div class="flex items-center gap-2 mb-3">
                                        <span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-md text-xs font-semibold {{ $badge['bg'] }}">
                                            <span class="w-1.5 h-1.5 rounded-full {{ $badge['dot'] }}"></span>
                                            {{ $group['name'] }}
                                        </span>
                                    </div>
                                    @if(!empty($group['items']))
                                        <ul class="space-y-2">
                                            @foreach($group['items'] as $item)
                                                @if($item['type'] === 'heading')
                                                    <li class="text-xs font-semibold text-gray-400 dark:text-gray-500 uppercase tracking-wider pt-2">{{ $item['text'] }}</li>
                                                @else
                                                    <li class="flex gap-2.5 text-sm text-gray-700 dark:text-gray-300 leading-relaxed">
                                                        <span class="mt-1.5 w-1.5 h-1.5 rounded-full {{ $badge['dot'] }} shrink-0 opacity-70"></span>
                                                        <span>{{ $item['text'] }}</span>
                                                    </li>
                                                @endif
                                            @endforeach
                                        </ul>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-400 dark:text-gray-500 text-sm italic">{{ __('ui.changelog.no_details') }}</p>
                    @endif

                </article>
            @endforeach
        </div>
    @endif

    {{-- Footer note --}}
    <div class="mt-16 pt-8 border-t border-gray-100 dark:border-gray-700 text-center text-sm text-gray-400 dark:text-gray-500">
        {!! __('ui.changelog.format_note', ['url' => 'https://keepachangelog.com/en/1.1.0/']) !!}
    </div>

</div>
