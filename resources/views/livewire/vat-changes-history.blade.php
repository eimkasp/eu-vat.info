@section('title', __('ui.history.meta_title'))
@section('meta_description', __('ui.history.meta_desc'))
@section('seo')
    <x-seo-meta 
        :title="__('ui.history.meta_title')"
        :description="__('ui.history.meta_desc')"
    />
@endsection

<div class="container pb-12">
    <x-breadcrumbs :items="[__('ui.breadcrumbs.vat_changelog') => '']" />

    <!-- Header -->
    <div class="mb-6">
        <h1 class="text-2xl font-bold mb-1">{{ __('ui.history.title') }}</h1>
        <p class="text-sm text-gray-500 dark:text-gray-400">{{ __('ui.history.subtitle') }}</p>
    </div>

    <!-- Filters -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-4 mb-6">
        <div class="grid sm:grid-cols-2 gap-3">
            <div>
                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">{{ __('ui.country') }}</label>
                <select wire:model.live="selectedCountry" class="w-full text-sm rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:border-blue-500 focus:ring-blue-500">
                    <option value="">{{ __('ui.history.all_countries') }}</option>
                    @foreach($countries as $country)
                        <option value="{{ $country->id }}">{{ $country->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">{{ __('ui.history.rate_type') }}</label>
                <select wire:model.live="selectedType" class="w-full text-sm rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:border-blue-500 focus:ring-blue-500">
                    <option value="">{{ __('ui.history.all_types') }}</option>
                    <option value="standard">{{ __('ui.history.standard_rate') }}</option>
                    <option value="reduced">{{ __('ui.history.reduced_rate') }}</option>
                    <option value="super_reduced">{{ __('ui.history.super_reduced_rate') }}</option>
                    <option value="parking">{{ __('ui.history.parking_rate') }}</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Changes List -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden mb-8">
        <div class="px-4 py-3 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900">
            <h3 class="text-sm font-semibold text-gray-700 dark:text-gray-300">{{ __('ui.history.all_changes') }}</h3>
        </div>
        
        @if($changes->count() > 0)
            <div class="divide-y divide-gray-100 dark:divide-gray-700">
                @foreach($changes as $change)
                    <div class="px-4 py-3 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                        <div class="flex items-center justify-between gap-3">
                            <div class="flex items-center gap-3 flex-1 min-w-0">
                                <img src="https://flagcdn.com/h40/{{ strtolower($change->country->iso_code) }}.jpg" 
                                     alt="{{ $change->country->name }}" 
                                     class="w-8 h-5 object-cover rounded shadow-sm shrink-0">
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center gap-2 flex-wrap">
                                        <h4 class="font-semibold text-sm text-gray-900 dark:text-gray-100">{{ $change->country->name }}</h4>
                                        <span class="inline-flex items-center px-1.5 py-0.5 rounded text-[11px] font-medium bg-blue-50 text-blue-700 dark:bg-blue-900/30 dark:text-blue-300">
                                            {{ ucfirst(str_replace('_', ' ', $change->type)) }}
                                        </span>
                                        <span class="font-semibold text-blue-600 dark:text-blue-400">{{ $change->rate }}%</span>
                                    </div>
                                    <div class="flex items-center gap-2 mt-0.5 text-xs text-gray-500 dark:text-gray-400">
                                        <span>{{ __('ui.history.effective_from', ['date' => $change->effective_from->format('M d, Y')]) }}</span>
                                        @if($change->effective_to)
                                            <span class="text-gray-400">·</span>
                                            <span>{{ __('ui.history.valid_until', ['date' => $change->effective_to->format('M d, Y')]) }}</span>
                                        @else
                                            <span class="text-gray-400">·</span>
                                            <span class="text-green-600 dark:text-green-400">✓ {{ __('ui.history.currently_active') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <a href="{{ locale_path('/vat-calculator/' . $change->country->slug) }}" 
                               class="text-xs text-blue-600 dark:text-blue-400 hover:underline whitespace-nowrap shrink-0">
                                Calculator →
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
        <h2 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">📊 {{ __('ui.history.stability_title') }}</h2>
        <p class="text-xs text-gray-500 dark:text-gray-400 mb-3">{{ __('ui.history.stability_desc') }}</p>
        
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-2">
            @foreach($countryStats as $stat)
                <div class="flex items-center gap-2 px-2.5 py-2 border border-gray-100 dark:border-gray-700 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                    <img src="https://flagcdn.com/h40/{{ strtolower($stat['iso_code']) }}.jpg" 
                         alt="{{ $stat['name'] }}" 
                         class="w-6 h-4 object-cover rounded shadow-sm shrink-0">
                    <div class="flex-1 min-w-0">
                        <div class="text-xs font-medium truncate text-gray-900 dark:text-gray-100">{{ $stat['name'] }}</div>
                        <div class="flex items-center gap-1">
                            <span class="text-[10px] text-gray-400 dark:text-gray-500">{{ $stat['changes_count'] }}</span>
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
                </div>
            @endforeach
        </div>
    </div>
</div>
