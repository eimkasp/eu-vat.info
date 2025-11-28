<div class="space-y-6">
    <!-- Mode Toggle -->
    <div class="flex items-center justify-center gap-2 p-1 bg-gray-100 dark:bg-gray-700 rounded-lg">
        <button 
            wire:click="$set('mode', 'exclude')"
            class="flex-1 px-4 py-3 rounded-md text-sm font-medium transition-all duration-200 {{ $mode === 'exclude' ? 'bg-white dark:bg-gray-800 text-blue-600 dark:text-blue-400 shadow-sm' : 'text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-200' }}">
            <div class="flex items-center justify-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                <span>Add VAT</span>
            </div>
        </button>
        <button 
            wire:click="$set('mode', 'include')"
            class="flex-1 px-4 py-3 rounded-md text-sm font-medium transition-all duration-200 {{ $mode === 'include' ? 'bg-white dark:bg-gray-800 text-blue-600 dark:text-blue-400 shadow-sm' : 'text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-200' }}">
            <div class="flex items-center justify-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                </svg>
                <span>Remove VAT</span>
            </div>
        </button>
    </div>

    <!-- Amount Input -->
    <div>
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
            {{ $mode === 'exclude' ? 'Net Amount (excluding VAT)' : 'Gross Amount (including VAT)' }}
        </label>
        <div class="relative">
            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-500 dark:text-gray-400 text-lg">€</span>
            <input 
                type="number" 
                wire:model.live.debounce.300ms="amount"
                step="0.01"
                min="0"
                class="w-full pl-10 pr-4 py-3 text-lg border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white"
                placeholder="100.00">
        </div>
    </div>

    <!-- VAT Rate Input -->
    <div>
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
            VAT Rate
        </label>
        <div class="relative">
            <input 
                type="number" 
                wire:model.live.debounce.300ms="vatRate"
                step="0.1"
                min="0"
                max="100"
                class="w-full pr-10 pl-4 py-3 text-lg border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white"
                placeholder="{{ $country->standard_rate }}">
            <span class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-500 dark:text-gray-400 text-lg">%</span>
        </div>
        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
            Standard rate for {{ $country->name }}: {{ $country->standard_rate }}%
        </p>
    </div>

    <!-- Results -->
    <div class="bg-gradient-to-br from-blue-50 to-blue-100 dark:from-blue-900/30 dark:to-blue-800/30 rounded-xl p-6 border-2 border-blue-200 dark:border-blue-700">
        <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Calculation Results</h3>
        
        <div class="space-y-3">
            <!-- Net Amount -->
            <div class="flex justify-between items-center pb-3 border-b border-blue-200 dark:border-blue-700">
                <span class="text-sm font-medium text-gray-600 dark:text-gray-400">Net Amount</span>
                <span class="text-lg font-bold text-gray-900 dark:text-white">
                    €{{ number_format($this->netAmount, 2) }}
                </span>
            </div>

            <!-- VAT Amount -->
            <div class="flex justify-between items-center pb-3 border-b border-blue-200 dark:border-blue-700">
                <span class="text-sm font-medium text-gray-600 dark:text-gray-400">VAT Amount ({{ $vatRate }}%)</span>
                <span class="text-lg font-bold text-blue-600 dark:text-blue-400">
                    €{{ number_format($this->vatAmount, 2) }}
                </span>
            </div>

            <!-- Gross Amount -->
            <div class="flex justify-between items-center pt-2">
                <span class="text-base font-bold text-gray-900 dark:text-white">Gross Amount</span>
                <span class="text-2xl font-bold text-gray-900 dark:text-white">
                    €{{ number_format($this->grossAmount, 2) }}
                </span>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="grid grid-cols-3 gap-2">
        <button 
            wire:click="$set('amount', 100)"
            class="px-4 py-2 text-sm bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 rounded-lg transition-colors">
            €100
        </button>
        <button 
            wire:click="$set('amount', 1000)"
            class="px-4 py-2 text-sm bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 rounded-lg transition-colors">
            €1,000
        </button>
        <button 
            wire:click="$set('amount', 10000)"
            class="px-4 py-2 text-sm bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 rounded-lg transition-colors">
            €10,000
        </button>
    </div>
</div>
