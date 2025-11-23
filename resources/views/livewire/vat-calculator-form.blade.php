<div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100">
    <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-3 text-white">
        <h2 class="text-xl font-semibold flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
            </svg>
            VAT Calculator
        </h2>
        <p class="text-blue-100 text-sm !mb-0 opacity-90">Calculate VAT rates instantly for any EU country</p>
    </div>

    <div class="p-6">
        <x-form wire:submit="calculate" class="space-y-6">
            {{-- Country Selection --}}
            <div class="space-y-2">
                <x-select 
                    wire:change="calculate" 
                    label="Select Country" 
                    :options="$countries" 
                    option-value="slug"
                    option-label="name" 
                    placeholder="Choose a country..." 
                    wire:model.live="selectedCountry1"
                    class="w-full"
                />
            </div>

            {{-- Amount Input --}}
            <div class="space-y-2">
                <x-input 
                    label="Amount" 
                    wire:change="calculate" 
                    wire:model.lazy="amount" 
                    type="text" 
                    suffix="EUR (€)" 
                    money 
                    class="text-lg font-medium"
                />
            </div>

            @isset($selectedCountryObject)
                {{-- VAT Rate Selection --}}
                <div class="bg-gray-50 p-4 rounded-xl border border-gray-200 space-y-3">
                    <label class="text-sm font-medium text-gray-700 block">VAT Rate</label>
                    <div class="grid grid-cols-1 gap-2">
                        @foreach($rates as $rate)
                            <label class="relative flex items-center p-3 rounded-lg border cursor-pointer hover:bg-white transition-colors {{ $selectedRate == $rate['value'] ? 'bg-white border-blue-500 ring-1 ring-blue-500' : 'border-gray-200' }}">
                                <input type="radio" name="rate" wire:model.live="selectedRate" value="{{ $rate['value'] }}" wire:change="calculate" class="h-4 w-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                                <span class="ml-3 flex flex-col">
                                    <span class="block text-sm font-medium text-gray-900">{{ $rate['name'] }}</span>
                                </span>
                            </label>
                        @endforeach
                    </div>
                </div>

                {{-- VAT Included/Excluded Toggle --}}
                <div class="flex p-1 bg-gray-100 rounded-lg">
                    @foreach($vat_options as $option)
                        <button 
                            type="button" 
                            wire:click="$set('vat_included', '{{ $option['value'] }}'); $call('calculate')"
                            class="flex-1 py-2 text-sm font-medium rounded-md transition-all duration-200 {{ $vat_included == $option['value'] ? 'bg-white text-blue-600 shadow-sm' : 'text-gray-500 hover:text-gray-700' }}"
                        >
                            {{ $option['name'] }}
                        </button>
                    @endforeach
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
                <div class="bg-gray-900 text-white rounded-xl p-6 shadow-lg mt-6 transform transition-all duration-300">
                    <div class="grid grid-cols-2 gap-4 mb-4 pb-4 border-b border-gray-700">
                        <div>
                            <div class="text-gray-400 text-xs uppercase tracking-wider mb-1">Net Amount</div>
                            <div class="font-medium">
                                {{ is_numeric($amount) ? Number::currency((float)($vat_included == 'include' ? $total - $vat_amount : $amount), 'EUR') : '0.00 €' }}
                            </div>
                        </div>
                        <div class="text-right">
                            <div class="text-gray-400 text-xs uppercase tracking-wider mb-1">VAT Amount ({{ $selectedRate }}%)</div>
                            <div class="font-medium text-blue-300">
                                {{ is_numeric($vat_amount) ? Number::currency((float)$vat_amount, 'EUR') : '0.00 €' }}
                            </div>
                        </div>
                    </div>
                    
                    <div class="flex justify-between items-end">
                        <div class="text-gray-300 text-sm">Total Amount</div>
                        <div class="text-3xl font-bold tracking-tight text-white">
                            {{ is_numeric($total) ? Number::currency((float)($vat_included == 'include' ? $amount : $total), 'EUR') : '0.00 €' }}
                        </div>
                    </div>
                </div>
            @endif

            <x-slot:actions>
                <div class="flex gap-3 w-full">
                    <x-button label="Save" class="flex-1 btn-outline" wire:click="saveSearch" icon="o-bookmark" />
                    <x-button label="Calculate" class="flex-1 btn-primary bg-blue-600 hover:bg-blue-700 text-white" type="submit" icon="o-calculator" />
                </div>
            </x-slot:actions>
        </x-form>
    </div>
</div>
