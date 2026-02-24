@section('title', __('ui.history.meta_title'))
@section('meta_description', __('ui.history.meta_desc'))
@section('seo')
    <x-seo-meta 
        :title="__('ui.history.meta_title')"
        :description="__('ui.history.meta_desc')"
    />
@endsection

<div class="mx-auto max-w-7xl px-4 py-6 sm:py-12">
    <div>
        <x-breadcrumbs :items="[__('ui.breadcrumbs.vat_changelog') => '']" />
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold mb-2">{{ __('ui.history.title') }}</h1>
            <p class="text-gray-600">{{ __('ui.history.subtitle') }}</p>
        </div>

        <!-- Historical Heatmap -->
        <div class="mb-8">
            <livewire:all-countries-vat-history />
        </div>

        <!-- Country Stability Overview -->
        <div class="bg-white p-6 rounded-xl shadow-xl mb-6">
            <h2 class="text-xl font-bold mb-4">📊 {{ __('ui.history.stability_title') }}</h2>
            <p class="text-sm text-gray-600 mb-4">{{ __('ui.history.stability_desc') }}</p>
            
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3">
                @foreach($countryStats as $stat)
                    <div class="flex items-center gap-2 p-3 border rounded-lg hover:bg-gray-50 transition-colors">
                        <img src="https://flagcdn.com/h40/{{ strtolower($stat['iso_code']) }}.jpg" 
                             alt="{{ $stat['name'] }}" 
                             class="w-8 h-5 object-cover rounded shadow-sm">
                        <div class="flex-1 min-w-0">
                            <div class="text-sm font-medium truncate">{{ $stat['name'] }}</div>
                            <div class="flex items-center gap-2">
                                <span class="text-xs text-gray-500">{{ $stat['changes_count'] }} {{ __('ui.history.changes') }}</span>
                                @if($stat['stability'] === 'excellent')
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800">
                                        {{ __('ui.history.excellent') }}
                                    </span>
                                @elseif($stat['stability'] === 'good')
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800">
                                        {{ __('ui.history.good') }}
                                    </span>
                                @elseif($stat['stability'] === 'moderate')
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-yellow-100 text-yellow-800">
                                        {{ __('ui.history.moderate') }}
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-red-100 text-red-800">
                                        {{ __('ui.history.frequent') }}
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Filters -->
        <div class="bg-white p-6 rounded-xl shadow-xl mb-6">
            <h3 class="font-bold mb-4">{{ __('ui.filters') }}</h3>
            <div class="grid md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('ui.country') }}</label>
                    <select wire:model.live="selectedCountry" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="">{{ __('ui.history.all_countries') }}</option>
                        @foreach($countries as $country)
                            <option value="{{ $country->id }}">{{ $country->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('ui.history.rate_type') }}</label>
                    <select wire:model.live="selectedType" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
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
        <div class="bg-white rounded-xl shadow-xl overflow-hidden">
            <div class="p-6 border-b bg-gray-50">
                <h3 class="font-bold">{{ __('ui.history.all_changes') }}</h3>
            </div>
            
            @if($changes->count() > 0)
                <div class="divide-y">
                    @foreach($changes as $change)
                        <div class="p-6 hover:bg-gray-50 transition-colors">
                            <div class="flex items-start justify-between">
                                <div class="flex items-center gap-4 flex-1">
                                    <img src="https://flagcdn.com/h40/{{ strtolower($change->country->iso_code) }}.jpg" 
                                         alt="{{ $change->country->name }}" 
                                         class="w-12 h-8 object-cover rounded shadow-sm">
                                    <div class="flex-1">
                                        <div class="flex items-center gap-3 mb-1">
                                            <h4 class="font-bold text-lg">{{ $change->country->name }}</h4>
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                {{ ucfirst(str_replace('_', ' ', $change->type)) }}
                                            </span>
                                        </div>
                                        <div class="text-gray-600">
                                            <span class="font-medium text-2xl text-blue-600">{{ $change->rate }}%</span>
                                            <span class="text-sm ml-2">{{ __('ui.history.effective_from', ['date' => $change->effective_from->format('F d, Y')]) }}</span>
                                        </div>
                                        @if($change->effective_to)
                                            <div class="text-sm text-gray-500 mt-1">
                                                {{ __('ui.history.valid_until', ['date' => $change->effective_to->format('F d, Y')]) }}
                                            </div>
                                        @else
                                            <div class="text-sm text-green-600 mt-1">
                                                ✓ {{ __('ui.history.currently_active') }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="text-right">
                                    <a href="{{ locale_path('/vat-calculator/' . $change->country->slug) }}" 
                                       class="text-sm text-blue-600 hover:underline">
                                        View Calculator →
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="p-6 border-t bg-gray-50">
                    {{ $changes->links() }}
                </div>
            @else
                <div class="p-12 text-center text-gray-500">
                    <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <p>{{ __('ui.history.no_changes') }}</p>
                </div>
            @endif
        </div>
    </div>
</div>
