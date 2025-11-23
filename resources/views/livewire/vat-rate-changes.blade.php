<div class="bg-white p-6 rounded-xl shadow-xl mb-6">
    <h3 class="text-lg font-bold mb-4">📊 Recent VAT Rate Changes</h3>
    
    @if($recentChanges->count() > 0)
        <div class="space-y-3">
            @foreach($recentChanges as $change)
                <div class="flex items-center justify-between p-3 hover:bg-gray-50 rounded-lg transition-colors">
                    <div class="flex items-center gap-3 flex-1">
                        <img src="https://flagcdn.com/h40/{{ strtolower($change->country->iso_code_2) }}.jpg" 
                             alt="{{ $change->country->name }} flag" 
                             class="w-8 h-5 object-cover rounded shadow-sm">
                        <div class="flex-1">
                            <div class="font-medium text-gray-900">{{ $change->country->name }}</div>
                            <div class="text-sm text-gray-500">
                                {{ ucfirst(str_replace('_', ' ', $change->type)) }} rate: {{ $change->rate }}%
                            </div>
                        </div>
                    </div>
                    <div class="text-right">
                        <div class="text-xs text-gray-400">
                            {{ $change->effective_from->format('M d, Y') }}
                        </div>
                        @if($change->effective_from > now()->subMonths(3))
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800">
                                Recent
                            </span>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="text-center py-8 text-gray-500">
            <svg class="mx-auto h-12 w-12 text-gray-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
            <p>No recent VAT rate changes</p>
        </div>
    @endif
    
    <div class="mt-4 pt-4 border-t">
        <a href="{{ route('vat-changes') }}" class="text-sm text-blue-600 hover:underline">View all changes →</a>
    </div>
</div>
