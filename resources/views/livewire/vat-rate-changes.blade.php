<div class="app-surface p-4 sm:p-5">
    <h3 class="mb-4 text-lg font-bold text-ink">{{ __('ui.rate_changes.title') }}</h3>
    
    @if($futureChanges->count() > 0)
        <div class="mb-6">
            <h4 class="mb-3 text-sm font-semibold text-ink-muted">{{ __('ui.rate_changes.upcoming') }}</h4>
            <div class="space-y-3">
                @foreach($futureChanges as $change)
                    <div class="flex items-center justify-between rounded-lg border border-blue-200 bg-action-soft p-3 transition-colors hover:bg-blue-100">
                        <div class="flex items-center gap-3 flex-1">
                            <img src="https://flagcdn.com/h40/{{ strtolower($change->country->iso_code) }}.jpg" 
                                 alt="{{ $change->country->name }} flag" 
                                 class="w-8 h-5 object-cover rounded shadow-sm">
                            <div class="flex-1">
                                <div class="font-medium text-ink">{{ $change->country->name }}</div>
                                <div class="text-sm text-ink-muted">
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
            <h4 class="mb-3 text-sm font-semibold text-ink-muted">{{ __('ui.rate_changes.recent') }}</h4>
            <div class="space-y-3">
                @foreach($recentChanges as $change)
                    <div class="flex items-center justify-between rounded-lg border border-transparent p-3 transition-colors hover:border-line hover:bg-surface-subtle">
                        <div class="flex items-center gap-3 flex-1">
                            <img src="https://flagcdn.com/h40/{{ strtolower($change->country->iso_code) }}.jpg" 
                                 alt="{{ $change->country->name }} flag" 
                                 class="w-8 h-5 object-cover rounded shadow-sm">
                            <div class="flex-1">
                                <div class="font-medium text-ink">{{ $change->country->name }}</div>
                                <div class="text-sm text-ink-muted">
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
                            <div class="text-xs text-gray-500">
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
            <p>{{ __('ui.rate_changes.no_changes') }}</p>
        </div>
    @endif
    
    <div class="mt-4 flex justify-between gap-3 border-t border-line pt-4">
        <a href="{{ locale_path('/vat-changes') }}" class="inline-flex min-h-11 items-center text-sm font-semibold text-action hover:text-action-deep">{{ __('ui.rate_changes.full_history') }} →</a>
        <a href="{{ locale_path('/vat-map') }}" class="inline-flex min-h-11 items-center text-right text-sm font-semibold text-action hover:text-action-deep">{{ __('ui.rate_changes.explore_map') }} →</a>
    </div>
</div>
