<div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg overflow-hidden border border-gray-100 dark:border-gray-700">
    {{-- Blue Header --}}
    <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-5 py-3.5 text-white">
        <h2 class="text-lg font-semibold flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
            </svg>
            {{ __('ui.country_page.vat_calculator') }}
        </h2>
        <p class="text-blue-100 text-sm opacity-90">{{ __('ui.calculator.calculate_instantly') }}</p>
    </div>

    <div class="p-4 space-y-4">
        {{-- Amount Input --}}
        <div>
            <label class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide block mb-1">{{ __('ui.calculator.amount') }}</label>
            <div class="relative flex">
                <input 
                    type="number" 
                    wire:model.live.debounce.300ms="amount"
                    step="0.01"
                    min="0"
                    class="w-full pl-4 pr-20 py-2.5 text-lg font-medium border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white"
                    placeholder="100.00">
                <span class="absolute right-3 top-1/2 -translate-y-1/2 text-sm font-medium text-gray-500 dark:text-gray-400 bg-gray-100 dark:bg-gray-600 px-2 py-1 rounded">{{ $country->currency_display }}</span>
            </div>
        </div>

        {{-- VAT Rate Selection --}}
        <div class="bg-gray-50 dark:bg-gray-900 px-3 py-2.5 rounded-xl border border-gray-200 dark:border-gray-700">
            <label class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide block mb-1.5">{{ __('ui.calculator.vat_rate') }}</label>
            <div class="flex flex-wrap gap-1.5">
                <label class="relative inline-flex items-center px-2.5 py-1 rounded-md border text-xs cursor-pointer hover:bg-white dark:hover:bg-gray-800 transition-colors {{ !$useCustomRate && $vatRate == $country->standard_rate ? 'bg-white dark:bg-gray-800 border-blue-500 ring-1 ring-blue-500 font-semibold text-blue-700 dark:text-blue-400' : 'border-gray-200 dark:border-gray-600 text-gray-700 dark:text-gray-300' }}">
                    <input type="radio" wire:click="setStandardRate" class="sr-only">
                    Standard ({{ $country->standard_rate }}%)
                </label>
                
                @if($country->reduced_rate)
                    <label class="relative inline-flex items-center px-2.5 py-1 rounded-md border text-xs cursor-pointer hover:bg-white dark:hover:bg-gray-800 transition-colors {{ !$useCustomRate && $vatRate == $country->reduced_rate ? 'bg-white dark:bg-gray-800 border-blue-500 ring-1 ring-blue-500 font-semibold text-blue-700 dark:text-blue-400' : 'border-gray-200 dark:border-gray-600 text-gray-700 dark:text-gray-300' }}">
                        <input type="radio" wire:click="setReducedRate" class="sr-only">
                        Reduced ({{ $country->reduced_rate }}%)
                    </label>
                @endif
                
                @if($country->super_reduced_rate)
                    <label class="relative inline-flex items-center px-2.5 py-1 rounded-md border text-xs cursor-pointer hover:bg-white dark:hover:bg-gray-800 transition-colors {{ !$useCustomRate && $vatRate == $country->super_reduced_rate ? 'bg-white dark:bg-gray-800 border-blue-500 ring-1 ring-blue-500 font-semibold text-blue-700 dark:text-blue-400' : 'border-gray-200 dark:border-gray-600 text-gray-700 dark:text-gray-300' }}">
                        <input type="radio" wire:click="setSuperReducedRate" class="sr-only">
                        Super Reduced ({{ $country->super_reduced_rate }}%)
                    </label>
                @endif

                @if($country->parking_rate)
                    <label class="relative inline-flex items-center px-2.5 py-1 rounded-md border text-xs cursor-pointer hover:bg-white dark:hover:bg-gray-800 transition-colors {{ !$useCustomRate && $vatRate == $country->parking_rate ? 'bg-white dark:bg-gray-800 border-blue-500 ring-1 ring-blue-500 font-semibold text-blue-700 dark:text-blue-400' : 'border-gray-200 dark:border-gray-600 text-gray-700 dark:text-gray-300' }}">
                        <input type="radio" wire:click="setParkingRate" class="sr-only">
                        Parking ({{ $country->parking_rate }}%)
                    </label>
                @endif
                
                {{-- Custom Rate --}}
                <label class="relative inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md border text-xs cursor-pointer hover:bg-white dark:hover:bg-gray-800 transition-colors {{ $useCustomRate ? 'bg-white dark:bg-gray-800 border-amber-500 ring-1 ring-amber-500 font-semibold text-amber-700 dark:text-amber-400' : 'border-gray-200 dark:border-gray-600 border-dashed text-gray-500 dark:text-gray-400' }}">
                    <input type="radio" wire:click="enableCustomRate" class="sr-only">
                    @if($useCustomRate)
                        <div class="flex items-center gap-1" @click.stop>
                            <input 
                                type="number" 
                                wire:model.live.debounce.300ms="vatRate"
                                step="0.1" min="0" max="100"
                                placeholder="15"
                                autofocus
                                class="w-14 px-1.5 py-0.5 text-xs border border-amber-300 dark:border-amber-600 rounded focus:ring-1 focus:ring-amber-500 focus:border-transparent bg-amber-50 dark:bg-amber-900/30 dark:text-amber-200">
                            <span class="text-xs font-medium text-gray-600 dark:text-gray-400">%</span>
                        </div>
                    @else
                        {{ __('ui.calculator.custom_rate') }}
                        <span class="px-1 py-0 bg-amber-100 dark:bg-amber-900/30 text-amber-700 dark:text-amber-400 rounded text-[10px] font-medium">%</span>
                    @endif
                </label>
            </div>
        </div>

        {{-- Mode Toggle --}}
        <div class="bg-gray-50 dark:bg-gray-900 px-3 py-2.5 rounded-xl border border-gray-200 dark:border-gray-700">
            <label class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide block mb-1.5">{{ __('ui.calculator.calculation_mode') }}</label>
            <div class="grid grid-cols-2 gap-2">
                <label class="cursor-pointer">
                    <input type="radio" wire:click="$set('mode', 'include')" class="peer sr-only">
                    <div class="px-3 py-2 rounded-lg border transition-all text-center {{ $mode === 'include' ? 'border-blue-600 bg-blue-50 dark:bg-blue-900/30 ring-1 ring-blue-500' : 'border-gray-200 dark:border-gray-600 hover:border-blue-200' }}">
                        <span class="font-semibold text-xs {{ $mode === 'include' ? 'text-blue-700 dark:text-blue-400' : 'text-gray-700 dark:text-gray-300' }}">{{ __('ui.calculator.includes_vat') }}</span>
                        <span class="block text-[10px] text-gray-500 dark:text-gray-400 mt-0.5">{{ __('ui.calculator.extract_vat') }}</span>
                    </div>
                </label>
                <label class="cursor-pointer">
                    <input type="radio" wire:click="$set('mode', 'exclude')" class="peer sr-only">
                    <div class="px-3 py-2 rounded-lg border transition-all text-center {{ $mode === 'exclude' ? 'border-blue-600 bg-blue-50 dark:bg-blue-900/30 ring-1 ring-blue-500' : 'border-gray-200 dark:border-gray-600 hover:border-blue-200' }}">
                        <span class="font-semibold text-xs {{ $mode === 'exclude' ? 'text-blue-700 dark:text-blue-400' : 'text-gray-700 dark:text-gray-300' }}">{{ __('ui.calculator.excludes_vat') }}</span>
                        <span class="block text-[10px] text-gray-500 dark:text-gray-400 mt-0.5">{{ __('ui.calculator.add_vat') }}</span>
                    </div>
                </label>
            </div>
        </div>

        {{-- Results --}}
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border-l-4 border-blue-600 overflow-hidden">
            <div class="p-4">
                <div class="grid grid-cols-2 gap-4 mb-3">
                    <div>
                        <div class="text-xs font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider mb-0.5">{{ __('ui.calculator.net_amount') }}</div>
                        <div class="text-lg font-medium text-gray-900 dark:text-white">
                            {{ $country->currency_display }}{{ number_format($this->netAmount, 2) }}
                        </div>
                    </div>
                    <div class="text-right">
                        <div class="text-xs font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider mb-0.5">VAT ({{ $vatRate }}%)</div>
                        <div class="text-lg font-medium text-blue-600 dark:text-blue-400">
                            {{ $country->currency_display }}{{ number_format($this->vatAmount, 2) }}
                        </div>
                    </div>
                </div>
                <div class="pt-3 border-t border-gray-100 dark:border-gray-700 flex justify-between items-center bg-gray-50 dark:bg-gray-900 -mx-4 -mb-4 px-4 py-3">
                    <span class="font-medium text-sm text-gray-500 dark:text-gray-400">{{ __('ui.calculator.total_to_pay') }}</span>
                    <span class="text-2xl font-bold text-gray-900 dark:text-white tracking-tight">
                        {{ $country->currency_display }}{{ number_format($this->grossAmount, 2) }}
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>
