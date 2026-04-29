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

<div class="max-w-2xl mx-auto px-4 py-10 sm:py-14">

    {{-- Breadcrumbs --}}
    <x-breadcrumbs :items="[__('ui.changelog.nav_label') => '']" />

    {{-- Header --}}
    <div class="mb-12">
        <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-blue-50 dark:bg-blue-950/60 border border-blue-100 dark:border-blue-800/60 text-blue-600 dark:text-blue-400 text-xs font-semibold mb-5">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" /></svg>
            Updated regularly
        </div>
        <h1 class="text-3xl sm:text-4xl font-extrabold text-gray-900 dark:text-white mb-3 tracking-tight">
            {{ __('ui.changelog.heading') }}
        </h1>
        <p class="text-gray-500 dark:text-gray-400 text-lg leading-relaxed max-w-xl">
            {{ __('ui.changelog.subheading') }}
        </p>
    </div>

    @if(empty($releases))
        <div class="text-gray-400 dark:text-gray-500 py-12 text-center text-sm">
            {{ __('ui.changelog.empty') }}
        </div>
    @else
        {{-- Timeline --}}
        <div class="relative">
            {{-- Vertical line --}}
            <div class="absolute left-[9px] top-3 bottom-3 w-px bg-gray-200 dark:bg-gray-700/60" aria-hidden="true"></div>

            <div class="space-y-14">
                @foreach($releases as $release)
                    @php
                        $isUnreleased = $release['version'] === 'Unreleased';
                        $anchor = $release['slug'];
                    @endphp

                    <article id="{{ $anchor }}" class="relative pl-9">

                        {{-- Timeline dot --}}
                        @if($isUnreleased)
                            <span class="absolute left-0 top-1 w-[18px] h-[18px] rounded-full bg-amber-400 dark:bg-amber-500 ring-4 ring-amber-50 dark:ring-amber-950/60 animate-pulse" aria-hidden="true"></span>
                        @else
                            <span class="absolute left-0 top-1 w-[18px] h-[18px] rounded-full bg-blue-500 dark:bg-blue-500 ring-4 ring-blue-50 dark:ring-blue-950/60" aria-hidden="true"></span>
                        @endif

                        {{-- Version header --}}
                        <header class="mb-5">
                            <div class="flex flex-wrap items-center gap-x-2 gap-y-1 mb-2">
                                @if($isUnreleased)
                                    <span class="text-xs font-bold uppercase tracking-widest text-amber-600 dark:text-amber-400">Coming soon</span>
                                @else
                                    <a href="#{{ $anchor }}" class="text-xs font-bold uppercase tracking-widest text-blue-600 dark:text-blue-400 hover:underline">
                                        v{{ $release['version'] }}
                                    </a>
                                @endif

                                @if($release['date'])
                                    <span class="text-gray-300 dark:text-gray-600 select-none">·</span>
                                    <time datetime="{{ $release['date'] }}" class="text-xs text-gray-400 dark:text-gray-500 tabular-nums">
                                        {{ \Carbon\Carbon::parse($release['date'])->format('d M Y') }}
                                    </time>
                                @endif
                            </div>

                            @if($release['subtitle'])
                                <h2 class="text-xl font-bold text-gray-900 dark:text-white leading-snug">
                                    {{ $release['subtitle'] }}
                                </h2>
                            @elseif($isUnreleased)
                                <h2 class="text-xl font-bold text-gray-900 dark:text-white leading-snug">
                                    In progress
                                </h2>
                            @endif
                        </header>

                        {{-- Groups --}}
                        @if(!empty($release['groups']))
                            <div class="space-y-6">
                                @foreach($release['groups'] as $group)
                                    @php
                                        $name = strtolower($group['name']);
                                        [$badgeClasses, $dotColor] = match($name) {
                                            'added'              => ['text-emerald-700 dark:text-emerald-400 bg-emerald-50 dark:bg-emerald-950/50 ring-1 ring-emerald-200 dark:ring-emerald-800/60', 'bg-emerald-500'],
                                            'fixed'              => ['text-rose-700 dark:text-rose-400 bg-rose-50 dark:bg-rose-950/50 ring-1 ring-rose-200 dark:ring-rose-800/60', 'bg-rose-500'],
                                            'improved','changed' => ['text-blue-700 dark:text-blue-400 bg-blue-50 dark:bg-blue-950/50 ring-1 ring-blue-200 dark:ring-blue-800/60', 'bg-blue-500'],
                                            'security'           => ['text-orange-700 dark:text-orange-400 bg-orange-50 dark:bg-orange-950/50 ring-1 ring-orange-200 dark:ring-orange-800/60', 'bg-orange-500'],
                                            'removed'            => ['text-gray-600 dark:text-gray-400 bg-gray-100 dark:bg-gray-800/60 ring-1 ring-gray-200 dark:ring-gray-700', 'bg-gray-400'],
                                            default              => ['text-indigo-700 dark:text-indigo-400 bg-indigo-50 dark:bg-indigo-950/50 ring-1 ring-indigo-200 dark:ring-indigo-800/60', 'bg-indigo-500'],
                                        };
                                    @endphp

                                    <div>
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-semibold {{ $badgeClasses }} mb-3">
                                            {{ ucfirst($group['name']) }}
                                        </span>

                                        @if(!empty($group['items']))
                                            <ul class="space-y-2.5">
                                                @foreach($group['items'] as $item)
                                                    @if($item['type'] === 'heading')
                                                        <li class="text-[11px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-widest pt-2">{{ $item['text'] }}</li>
                                                    @else
                                                        <li class="flex items-start gap-3">
                                                            <span class="mt-[8px] w-1 h-1 rounded-full {{ $dotColor }} shrink-0 opacity-60"></span>
                                                            <span class="text-[15px] text-gray-600 dark:text-gray-300 leading-relaxed">{{ $item['text'] }}</span>
                                                        </li>
                                                    @endif
                                                @endforeach
                                            </ul>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-sm text-gray-400 dark:text-gray-500 italic">{{ __('ui.changelog.no_details') }}</p>
                        @endif

                    </article>
                @endforeach
            </div>
        </div>
    @endif

</div>

