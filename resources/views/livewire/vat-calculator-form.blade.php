<div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100">
    <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-4 text-white flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h2 class="text-xl font-semibold flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                </svg>
                VAT Calculator
            </h2>
            <p class="text-blue-100 text-sm !mb-0 opacity-90">{{ __('ui.calculator.calculate_instantly') }}</p>
        </div>

        <div class="w-full sm:w-auto">
            <div class="relative">
                <select wire:model.live="selectedCountry1" class="appearance-none bg-blue-800/30 border border-blue-400/50 text-white rounded-lg pl-4 pr-10 py-2 text-sm focus:ring-2 focus:ring-white/50 focus:border-white transition-all cursor-pointer hover:bg-blue-800/50 w-full sm:w-64" style="color: white; background-color: rgba(30, 64, 175, 0.3);">
                    @foreach($countries as $country)
                        <option value="{{ $country->slug }}" style="color: #111827; background-color: white;">
                            {{ $country->name_with_flag }}
                        </option>
                    @endforeach
                </select>
                <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none text-blue-200">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <div class="p-4">
        <x-form wire:submit="calculate" class="space-y-4">
            {{-- Amount Input --}}
            <div class="space-y-2">
                <x-input 
                    label="{{ __('ui.calculator.amount') }}" 
                    wire:change="calculate" 
                    wire:model.lazy="amount" 
                    type="text" 
                    suffix="{{ $selectedCountryObject?->currency_display ?? 'EUR (€)' }}" 
                    money 
                    class="text-lg font-medium"
                />
            </div>

            @isset($selectedCountryObject)
                {{-- VAT Rate Selection --}}
                <div class="bg-gray-50 px-3 py-2 rounded-xl border border-gray-200">
                    <label class="text-xs font-medium text-gray-500 uppercase tracking-wide block mb-1.5">{{ __('ui.calculator.vat_rate') }}</label>
                    <div class="flex flex-wrap gap-1.5">
                        @foreach($rates as $rate)
                            <label class="relative inline-flex items-center px-2.5 py-1 rounded-md border text-xs cursor-pointer hover:bg-white transition-colors {{ !$useCustomRate && $selectedRate == $rate['value'] ? 'bg-white border-blue-500 ring-1 ring-blue-500 font-semibold text-blue-700' : 'border-gray-200 text-gray-700' }}">
                                <input type="radio" name="rate" wire:click="selectPresetRate({{ $rate['value'] }})" value="{{ $rate['value'] }}" {{ !$useCustomRate && $selectedRate == $rate['value'] ? 'checked' : '' }} class="sr-only">
                                {{ $rate['name'] }}
                            </label>
                        @endforeach
                        
                        {{-- Custom Rate Option --}}
                        <label class="relative inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md border text-xs cursor-pointer hover:bg-white transition-colors {{ $useCustomRate ? 'bg-white border-amber-500 ring-1 ring-amber-500 font-semibold text-amber-700' : 'border-gray-200 border-dashed text-gray-500' }}">
                            <input type="radio" name="rate" wire:click="$set('useCustomRate', true)" {{ $useCustomRate ? 'checked' : '' }} class="sr-only">
                            @if($useCustomRate)
                                <div class="flex items-center gap-1" @click.stop>
                                    <input 
                                        type="number" 
                                        wire:model.live.debounce.300ms="customRate"
                                        wire:change="setCustomRate"
                                        step="0.1" 
                                        min="0" 
                                        max="100"
                                        placeholder="15"
                                        autofocus
                                        class="w-14 px-1.5 py-0.5 text-xs border border-amber-300 rounded focus:ring-1 focus:ring-amber-500 focus:border-transparent bg-amber-50">
                                    <span class="text-xs font-medium text-gray-600">%</span>
                                </div>
                            @else
                                {{ __('ui.calculator.custom_rate') }}
                                <span class="px-1 py-0 bg-amber-100 text-amber-700 rounded text-[10px] font-medium">%</span>
                            @endif
                        </label>
                    </div>
                </div>

                {{-- VAT Included/Excluded Toggle --}}
                <div class="bg-gray-50 px-3 py-2 rounded-xl border border-gray-200">
                    <label class="text-xs font-medium text-gray-500 uppercase tracking-wide block mb-1.5">{{ __('ui.calculator.calculation_mode') }}</label>
                    <div class="grid grid-cols-2 gap-2">
                        <label class="cursor-pointer">
                            <input type="radio" name="vat_included" value="include" class="peer sr-only" wire:model.live="vat_included">
                            <div class="px-3 py-2 rounded-lg border transition-all text-center {{ $vat_included === 'include' ? 'border-blue-600 bg-blue-50 ring-1 ring-blue-500' : 'border-gray-200 hover:border-blue-200' }}">
                                <span class="font-semibold text-xs {{ $vat_included === 'include' ? 'text-blue-700' : 'text-gray-700' }}">{{ __('ui.calculator.includes_vat') }}</span>
                                <span class="block text-[10px] text-gray-500 mt-0.5">{{ __('ui.calculator.extract_vat') }}</span>
                            </div>
                        </label>
                        <label class="cursor-pointer">
                            <input type="radio" name="vat_included" value="exclude" class="peer sr-only" wire:model.live="vat_included">
                            <div class="px-3 py-2 rounded-lg border transition-all text-center {{ $vat_included === 'exclude' ? 'border-blue-600 bg-blue-50 ring-1 ring-blue-500' : 'border-gray-200 hover:border-blue-200' }}">
                                <span class="font-semibold text-xs {{ $vat_included === 'exclude' ? 'text-blue-700' : 'text-gray-700' }}">{{ __('ui.calculator.excludes_vat') }}</span>
                                <span class="block text-[10px] text-gray-500 mt-0.5">{{ __('ui.calculator.add_vat') }}</span>
                            </div>
                        </label>
                    </div>
                </div>
            @endisset

            @if($error_message)
                <div class="bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded-lg text-sm flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                    </svg>
                    {{ $error_message }}
                </div>
            @endif

            {{-- Results Section --}}
            @if ($total && !$error_message)
                <div class="bg-white rounded-xl shadow-lg mt-4 overflow-hidden border-l-4 border-blue-600"
                     wire:transition.scale.origin.top>
                    <div class="p-4" wire:loading.class="opacity-50" wire:target="calculate">
                        <div class="grid grid-cols-2 gap-6 mb-4">
                            <div>
                                <div class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">{{ __('ui.calculator.net_amount') }}</div>
                                <div class="text-xl font-medium text-gray-900">
                                    {{ is_numeric($amount) ? ($selectedCountryObject ? $selectedCountryObject->currency_display : '€') . number_format((float)($vat_included == 'include' ? $total - $vat_amount : $amount), 2) : '0.00' }}
                                </div>
                            </div>
                            <div class="text-right">
                                <div class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">VAT ({{ $selectedRate }}%)</div>
                                <div class="text-xl font-medium text-blue-600">
                                    {{ is_numeric($vat_amount) ? ($selectedCountryObject ? $selectedCountryObject->currency_display : '€') . number_format((float)$vat_amount, 2) : '0.00' }}
                                </div>
                            </div>
                        </div>
                        
                        <div class="pt-4 border-t border-gray-100 flex justify-between items-center bg-gray-50 -mx-4 -mb-4 px-4 py-3">
                            <span class="font-medium text-gray-500">{{ __('ui.calculator.total_to_pay') }}</span>
                            <span class="text-3xl font-bold text-gray-900 tracking-tight">
                                {{ is_numeric($total) ? ($selectedCountryObject ? $selectedCountryObject->currency_display : '€') . number_format((float)($vat_included == 'include' ? $amount : $total), 2) : '0.00' }}
                            </span>
                        </div>
                    </div>
                </div>
            @endif

            <x-slot:actions>
                <div class="flex gap-3 w-full">
                    <x-button label="{{ __('ui.save') }}" class="flex-1 btn-outline" wire:click="saveSearch" icon="o-bookmark" spinner="saveSearch" />
                    <x-button label="{{ __('ui.calculate') }}" class="flex-1 btn-primary bg-blue-600 hover:bg-blue-700 text-white" type="submit" icon="o-calculator" spinner="calculate" />
                </div>
            </x-slot:actions>
        </x-form>
    </div>
</div>
