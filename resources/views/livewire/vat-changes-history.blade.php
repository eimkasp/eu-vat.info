@section('title', __('ui.history.meta_title'))
@section('meta_description', __('ui.history.meta_desc'))
@section('seo')
    <x-seo-meta 
        :title="__('ui.history.meta_title')"
        :description="__('ui.history.meta_desc')"
        :url="url(locale_path('/vat-changes'))">
        <script type="application/ld+json">
        {
            "@context": "https://schema.org",
            "@type": "WebPage",
            "name": "{{ __('ui.history.meta_title') }}",
            "description": "{{ __('ui.history.meta_desc') }}",
            "url": "{{ url(locale_path('/vat-changes')) }}",
            "inLanguage": "{{ app()->getLocale() }}",
            "isPartOf": {
                "@type": "WebSite",
                "name": "{{ __('ui.site_name') }}",
                "url": "{{ url(locale_path('/')) }}"
            },
            "breadcrumb": {
                "@type": "BreadcrumbList",
                "itemListElement": [
                    {
                        "@type": "ListItem",
                        "position": 1,
                        "name": "{{ __('ui.site_name') }}",
                        "item": "{{ url(locale_path('/')) }}"
                    },
                    {
                        "@type": "ListItem",
                        "position": 2,
                        "name": "{{ __('ui.history.title') }}",
                        "item": "{{ url(locale_path('/vat-changes')) }}"
                    }
                ]
            }
        }
        </script>
    </x-seo-meta>
@endsection

<div class="container pb-12">
    <x-breadcrumbs :items="[__('ui.breadcrumbs.vat_changelog') => '']" />

    <!-- Header -->
    <div class="mb-6">
        <h1 class="text-3xl font-bold mb-1 text-gray-900 dark:text-white">{{ __('ui.history.title') }}</h1>
        <p class="text-sm text-gray-500 dark:text-gray-400">{{ __('ui.history.subtitle') }}</p>
    </div>

    <!-- Filters -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-4 mb-6">
        <div class="grid sm:grid-cols-3 gap-3">
            <div>
                <label for="filter-country" class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">{{ __('ui.country') }}</label>
                <select id="filter-country" wire:model.live="selectedCountry" class="w-full text-sm rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:border-blue-500 focus:ring-blue-500">
                    <option value="">{{ __('ui.history.all_countries') }}</option>
                    @foreach($countries as $country)
                        <option value="{{ $country->id }}">{{ $country->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="filter-type" class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">{{ __('ui.history.rate_type') }}</label>
                <select id="filter-type" wire:model.live="selectedType" class="w-full text-sm rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:border-blue-500 focus:ring-blue-500">
                    <option value="">{{ __('ui.history.all_types') }}</option>
                    <option value="standard">{{ __('ui.history.standard_rate') }}</option>
                    <option value="reduced">{{ __('ui.history.reduced_rate') }}</option>
                    <option value="super_reduced">{{ __('ui.history.super_reduced_rate') }}</option>
                    <option value="parking">{{ __('ui.history.parking_rate') }}</option>
                </select>
            </div>
            <div>
                <label for="filter-direction" class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">{{ __('ui.history.direction') }}</label>
                <select id="filter-direction" wire:model.live="selectedDirection" class="w-full text-sm rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:border-blue-500 focus:ring-blue-500">
                    <option value="">{{ __('ui.history.all_directions') }}</option>
                    <option value="increase">{{ __('ui.history.increases') }}</option>
                    <option value="decrease">{{ __('ui.history.decreases') }}</option>
                </select>
            </div>
        </div>
        @if($hasFilters)
            <div class="mt-3 flex items-center justify-between">
                <span class="text-xs text-gray-500 dark:text-gray-400">
                    {{ trans_choice('ui.history.results_count', $changes->total(), ['count' => $changes->total()]) }}
                </span>
                <button wire:click="resetFilters" class="text-xs text-blue-600 dark:text-blue-400 hover:underline flex items-center gap-1">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    {{ __('ui.history.clear_filters') }}
                </button>
            </div>
        @endif
    </div>

    <!-- Changes List -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden mb-8" wire:loading.class="opacity-60">
        <div class="px-4 py-3 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 flex items-center justify-between">
            <h2 class="text-sm font-semibold text-gray-700 dark:text-gray-300">{{ __('ui.history.all_changes') }}</h2>
            <div wire:loading class="flex items-center gap-1.5 text-xs text-blue-600 dark:text-blue-400">
                <svg class="animate-spin h-3 w-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                {{ __('ui.history.loading') }}
            </div>
        </div>
        
        @if($changes->count() > 0)
            <div class="divide-y divide-gray-100 dark:divide-gray-700">
                @foreach($changes as $change)
                    <div class="px-4 py-3 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                        <div class="flex items-center justify-between gap-3">
                            <div class="flex items-center gap-3 flex-1 min-w-0">
                                <img src="https://flagcdn.com/h40/{{ strtolower($change->country->iso_code) }}.jpg" 
                                     alt="{{ $change->country->name }}" 
                                     loading="lazy"
                                     class="w-8 h-5 object-cover rounded shadow-sm shrink-0">
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center gap-2 flex-wrap">
                                        <h3 class="font-semibold text-sm text-gray-900 dark:text-gray-100">{{ $change->country->name }}</h3>
                                        <span class="inline-flex items-center px-1.5 py-0.5 rounded text-[11px] font-medium bg-blue-50 text-blue-700 dark:bg-blue-900/30 dark:text-blue-300">
                                            {{ ucfirst(str_replace('_', ' ', $change->rate_type)) }}
                                        </span>
                                        @if($change->change_direction === 'increase')
                                            <span class="inline-flex items-center gap-0.5 text-xs font-semibold text-red-600 dark:text-red-400">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path></svg>
                                                {{ $change->old_rate }}% → {{ $change->new_rate }}%
                                            </span>
                                        @elseif($change->change_direction === 'decrease')
                                            <span class="inline-flex items-center gap-0.5 text-xs font-semibold text-green-600 dark:text-green-400">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                                {{ $change->old_rate }}% → {{ $change->new_rate }}%
                                            </span>
                                        @else
                                            <span class="text-xs font-semibold text-gray-500 dark:text-gray-400">
                                                {{ $change->old_rate }}% → {{ $change->new_rate }}%
                                            </span>
                                        @endif
                                    </div>
                                    <div class="flex items-center gap-2 mt-0.5 text-xs text-gray-500 dark:text-gray-400">
                                        <span>{{ __('ui.history.changed_on', ['date' => $change->change_date->format('M d, Y')]) }}</span>
                                        @if($change->description)
                                            <span class="text-gray-400">·</span>
                                            <span class="truncate">{{ $change->description }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <a href="{{ locale_path('/vat-calculator/' . $change->country->slug) }}" 
                               class="text-xs text-blue-600 dark:text-blue-400 hover:underline whitespace-nowrap shrink-0">
                                {{ __('ui.history.view_calculator') }} →
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="px-4 py-3 border-t border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900">
                {{ $changes->links() }}
            </div>
        @else
            <div class="p-8 text-center text-gray-500 dark:text-gray-400">
                <svg class="mx-auto h-10 w-10 text-gray-300 dark:text-gray-600 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                <p class="text-sm">{{ __('ui.history.no_changes') }}</p>
            </div>
        @endif
    </div>

    <!-- Country Stability Overview -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-4">
        <div class="flex items-center justify-between mb-3">
            <div>
                <h2 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">📊 {{ __('ui.history.stability_title') }}</h2>
                <p class="text-xs text-gray-500 dark:text-gray-400">{{ __('ui.history.stability_desc') }}</p>
            </div>
            <div class="hidden sm:flex items-center gap-3 text-[10px] text-gray-500 dark:text-gray-400">
                <span class="flex items-center gap-1"><span class="inline-block w-2 h-2 rounded-full bg-green-400"></span> {{ __('ui.history.excellent') }}</span>
                <span class="flex items-center gap-1"><span class="inline-block w-2 h-2 rounded-full bg-blue-400"></span> {{ __('ui.history.good') }}</span>
                <span class="flex items-center gap-1"><span class="inline-block w-2 h-2 rounded-full bg-yellow-400"></span> {{ __('ui.history.moderate') }}</span>
                <span class="flex items-center gap-1"><span class="inline-block w-2 h-2 rounded-full bg-red-400"></span> {{ __('ui.history.frequent') }}</span>
            </div>
        </div>
        
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-2">
            @foreach($countryStats as $stat)
                <a href="{{ locale_path('/vat-calculator/' . $stat['slug']) }}"
                   class="flex items-center gap-2 px-2.5 py-2 border border-gray-100 dark:border-gray-700 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                    <img src="https://flagcdn.com/h40/{{ strtolower($stat['iso_code']) }}.jpg" 
                         alt="{{ $stat['name'] }}" 
                         loading="lazy"
                         class="w-6 h-4 object-cover rounded shadow-sm shrink-0">
                    <div class="flex-1 min-w-0">
                        <div class="text-xs font-medium truncate text-gray-900 dark:text-gray-100">{{ $stat['name'] }}</div>
                        <div class="flex items-center gap-1">
                            <span class="text-[10px] text-gray-400 dark:text-gray-500">{{ $stat['changes_count'] }} {{ __('ui.history.changes') }}</span>
                            @if($stat['stability'] === 'excellent')
                                <span class="inline-block w-1.5 h-1.5 rounded-full bg-green-400"></span>
                            @elseif($stat['stability'] === 'good')
                                <span class="inline-block w-1.5 h-1.5 rounded-full bg-blue-400"></span>
                            @elseif($stat['stability'] === 'moderate')
                                <span class="inline-block w-1.5 h-1.5 rounded-full bg-yellow-400"></span>
                            @else
                                <span class="inline-block w-1.5 h-1.5 rounded-full bg-red-400"></span>
                            @endif
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</div>
