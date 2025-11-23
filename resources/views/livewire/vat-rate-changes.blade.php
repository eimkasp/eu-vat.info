<div class="bg-white p-6 rounded-xl shadow-xl mb-6">
    <h3 class="text-lg font-bold mb-4">📊 VAT Rate Changes</h3>
    
    @if($futureChanges->count() > 0)
        <div class="mb-6">
            <h4 class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-3">Upcoming Changes</h4>
            <div class="space-y-3">
                @foreach($futureChanges as $change)
                    <div class="flex items-center justify-between p-3 bg-blue-50 hover:bg-blue-100 rounded-lg transition-colors border border-blue-100">
                        <div class="flex items-center gap-3 flex-1">
                            <img src="https://flagcdn.com/h40/{{ strtolower($change->country->iso_code) }}.jpg" 
                                 alt="{{ $change->country->name }} flag" 
                                 class="w-8 h-5 object-cover rounded shadow-sm">
                            <div class="flex-1">
                                <div class="font-medium text-gray-900">{{ $change->country->name }}</div>
                                <div class="text-sm text-gray-500">
                                    {{ ucfirst(str_replace('_', ' ', $change->type)) }} rate: 
                                    <span class="font-semibold">{{ $change->rate }}%</span>
                                    @if($change->diff != 0)
                                        <span class="ml-1 text-xs font-medium {{ $change->diff > 0 ? 'text-red-600' : 'text-green-600' }}">
                                            ({{ $change->diff > 0 ? '+' : '' }}{{ $change->diff }}%)
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="text-right">
                            <div class="text-sm font-medium text-blue-800">
                                {{ $change->effective_from->format('M Y') }}
                            </div>
                            <div class="text-xs text-blue-600">
                                {{ $change->effective_from->diffForHumans() }}
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    @if($recentChanges->count() > 0)
        <div>
            <h4 class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-3">Recent Changes</h4>
            <div class="space-y-3">
                @foreach($recentChanges as $change)
                    <div class="flex items-center justify-between p-3 hover:bg-gray-50 rounded-lg transition-colors border border-transparent hover:border-gray-200">
                        <div class="flex items-center gap-3 flex-1">
                            <img src="https://flagcdn.com/h40/{{ strtolower($change->country->iso_code) }}.jpg" 
                                 alt="{{ $change->country->name }} flag" 
                                 class="w-8 h-5 object-cover rounded shadow-sm">
                            <div class="flex-1">
                                <div class="font-medium text-gray-900">{{ $change->country->name }}</div>
                                <div class="text-sm text-gray-500">
                                    {{ ucfirst(str_replace('_', ' ', $change->type)) }} rate: 
                                    <span class="font-semibold">{{ $change->rate }}%</span>
                                    @if($change->diff != 0)
                                        <span class="ml-1 text-xs font-medium {{ $change->diff > 0 ? 'text-red-600' : 'text-green-600' }}">
                                            ({{ $change->diff > 0 ? '+' : '' }}{{ $change->diff }}%)
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="text-right">
                            <div class="text-xs text-gray-500">
                                {{ $change->effective_from->format('M d, Y') }}
                            </div>
                            <div class="text-xs text-gray-400">
                                {{ $change->effective_from->diffForHumans() }}
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @elseif($futureChanges->count() == 0)
        <div class="text-center py-8 text-gray-500">
            <svg class="mx-auto h-12 w-12 text-gray-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
            <p>No recent or upcoming VAT rate changes</p>
        </div>
    @endif
    
    <div class="mt-4 pt-4 border-t">
        <a href="{{ route('vat-changes') }}" class="text-sm text-blue-600 hover:underline">View all changes →</a>
    </div>
</div>
