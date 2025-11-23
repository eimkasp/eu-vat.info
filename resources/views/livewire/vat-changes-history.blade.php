@section('title', 'VAT Rate Changes History - EU VAT Info')
@section('meta_description', 'Complete history of VAT rate changes across European Union countries. Track standard and reduced rate modifications with stability indicators.')
@section('seo')
    <x-seo-meta 
        title="VAT Rate Changes History - EU Countries | EU VAT Info"
        description="Complete history of VAT rate changes across all EU countries from 2000 onwards. Track standard and reduced rate modifications with country stability indicators."
    />
@endsection

<div class="container py-12 mt-12">
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold mb-2">VAT Rate Changes History</h1>
            <p class="text-gray-600">Track all VAT rate modifications across EU countries over the past decade</p>
        </div>

        <!-- Country Stability Overview -->
        <div class="bg-white p-6 rounded-xl shadow-xl mb-6">
            <h2 class="text-xl font-bold mb-4">📊 Country Stability Indicators</h2>
            <p class="text-sm text-gray-600 mb-4">Countries with fewer VAT rate changes indicate more stable tax environments</p>
            
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3">
                @foreach($countryStats as $stat)
                    <div class="flex items-center gap-2 p-3 border rounded-lg hover:bg-gray-50 transition-colors">
                        <img src="https://flagcdn.com/h40/{{ strtolower($stat['iso_code_2']) }}.jpg" 
                             alt="{{ $stat['name'] }}" 
                             class="w-8 h-5 object-cover rounded shadow-sm">
                        <div class="flex-1 min-w-0">
                            <div class="text-sm font-medium truncate">{{ $stat['name'] }}</div>
                            <div class="flex items-center gap-2">
                                <span class="text-xs text-gray-500">{{ $stat['changes_count'] }} changes</span>
                                @if($stat['stability'] === 'excellent')
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800">
                                        Excellent
                                    </span>
                                @elseif($stat['stability'] === 'good')
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800">
                                        Good
                                    </span>
                                @elseif($stat['stability'] === 'moderate')
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-yellow-100 text-yellow-800">
                                        Moderate
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-red-100 text-red-800">
                                        Frequent
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
            <h3 class="font-bold mb-4">Filters</h3>
            <div class="grid md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Country</label>
                    <select wire:model.live="selectedCountry" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="">All Countries</option>
                        @foreach($countries as $country)
                            <option value="{{ $country->id }}">{{ $country->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Rate Type</label>
                    <select wire:model.live="selectedType" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="">All Types</option>
                        <option value="standard">Standard Rate</option>
                        <option value="reduced">Reduced Rate</option>
                        <option value="super_reduced">Super Reduced Rate</option>
                        <option value="parking">Parking Rate</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Changes List -->
        <div class="bg-white rounded-xl shadow-xl overflow-hidden">
            <div class="p-6 border-b bg-gray-50">
                <h3 class="font-bold">All Changes (Past 10 Years)</h3>
            </div>
            
            @if($changes->count() > 0)
                <div class="divide-y">
                    @foreach($changes as $change)
                        <div class="p-6 hover:bg-gray-50 transition-colors">
                            <div class="flex items-start justify-between">
                                <div class="flex items-center gap-4 flex-1">
                                    <img src="https://flagcdn.com/h40/{{ strtolower($change->country->iso_code_2) }}.jpg" 
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
                                            <span class="text-sm ml-2">effective from {{ $change->effective_from->format('F d, Y') }}</span>
                                        </div>
                                        @if($change->effective_to)
                                            <div class="text-sm text-gray-500 mt-1">
                                                Valid until: {{ $change->effective_to->format('F d, Y') }}
                                            </div>
                                        @else
                                            <div class="text-sm text-green-600 mt-1">
                                                ✓ Currently active
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="text-right">
                                    <a href="{{ route('vat-calculator.country', $change->country->slug) }}" 
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
                    <p>No VAT rate changes found matching your criteria</p>
                </div>
            @endif
        </div>
    </div>
</div>
