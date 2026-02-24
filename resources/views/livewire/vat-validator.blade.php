<div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100 mt-12">
    <div class="bg-gradient-to-r from-indigo-600 to-indigo-700 px-6 py-3 text-white">
        <h2 class="text-xl font-semibold flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            VAT Number Validator
        </h2>
        <p class="text-indigo-100 text-sm !mb-0 opacity-90">{{ __('ui.validator.subtitle') }}</p>
    </div>

    <div class="p-6">
        <div class="mb-6 text-sm text-gray-600">
            <p class="mb-2">Enter a country code and VAT number to check its validity in the official EU VIES database.</p>
            <p>Need an example? <button type="button" wire:click="prefillExample" class="text-indigo-600 hover:underline font-medium">Try LT100019070512</button></p>
        </div>

        <form wire:submit.prevent="validateVat" class="space-y-4">
            <div class="grid sm:grid-cols-3 gap-4">
                <div class="sm:col-span-1">
                    <x-select 
                        label="{{ __('ui.country') }}" 
                        :options="$countries" 
                        option-value="iso_code"
                        option-label="name" 
                        placeholder="Select" 
                        wire:model="countryCode"
                        class="w-full"
                    />
                </div>
                <div class="sm:col-span-2">
                    <x-input 
                        label="{{ __('ui.validator.enter_number') }}" 
                        wire:model="vatNumber" 
                        type="text" 
                        placeholder="e.g. 123456789"
                        class="w-full"
                    />
                </div>
            </div>

            <div class="flex justify-end">
                <x-button label="{{ __('ui.validator.validate') }}" class="btn-primary bg-indigo-600 hover:bg-indigo-700 text-white" type="submit" icon="o-check-circle" spinner="validateVat" />
            </div>
        </form>

        @if($error)
            <div class="mt-4 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg text-sm flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                </svg>
                {{ $error }}
            </div>
        @endif

        @if($result)
            <div class="mt-6 pt-6 border-t border-gray-100" wire:transition.scale.origin.top>
                <div class="rounded-lg p-4 {{ $result['valid'] ? 'bg-green-50 border border-green-200' : 'bg-red-50 border border-red-200' }}">
                    <div class="flex items-center gap-2 mb-3">
                        @if($result['valid'])
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <h3 class="text-lg font-bold text-green-800">{{ __('ui.validator.valid') }} VAT</h3>
                        @else
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <h3 class="text-lg font-bold text-red-800">{{ __('ui.validator.invalid') }} VAT</h3>
                        @endif
                    </div>

                    @if($result['valid'])
                        <div class="space-y-2 text-sm">
                            <div class="flex justify-between py-1 border-b border-green-200">
                                <span class="text-green-700 font-medium">{{ __('ui.validator.company_name') }}</span>
                                <span class="text-gray-900">{{ $result['name'] }}</span>
                            </div>
                            <div class="flex justify-between py-1 border-b border-green-200">
                                <span class="text-green-700 font-medium">{{ __('ui.validator.company_address') }}</span>
                                <span class="text-gray-900">{{ $result['address'] }}</span>
                            </div>
                            <div class="flex justify-between py-1">
                                <span class="text-green-700 font-medium">Request ID</span>
                                <span class="text-gray-500 font-mono text-xs">{{ $result['requestIdentifier'] }}</span>
                            </div>
                        </div>
                    @endif
                    
                    @if($validationCount > 0)
                        <div class="mt-3 pt-3 border-t border-gray-200 text-xs text-gray-500 flex items-center gap-1">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4">
                                <path d="M10 12.5a2.5 2.5 0 100-5 2.5 2.5 0 000 5z" />
                                <path fill-rule="evenodd" d="M.664 10.59a1.651 1.651 0 010-1.186A10.004 10.004 0 0110 3c4.257 0 7.893 2.66 9.336 6.41.147.381.146.804 0 1.186A10.004 10.004 0 0110 17c-4.257 0-7.893-2.66-9.336-6.41zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                            </svg>
                            Checked {{ $validationCount }} times by users
                        </div>
                    @endif
                </div>
            </div>
        @endif
    </div>
</div>
