<div>
    <div class="font-medium">
        <x-form class="bg-blue-50 p-6 rounded shadow-xl" wire:submit="calculate">
            <div class="grid sm:grid-cols-1 gap-3">
                <div class="sm:col-span-6 gap-3 grid">
                    <x-select wire:change="calculate" label="Country" :options="$countries" option-value="slug"
                        option-label="name" placeholder="Select a country" {{-- Set a value for placeholder. Default is `null` --}}
                        wire:model.live="selectedCountry1" />
                </div>

                <div class="sm:col-span-6 grid gap-3">
                    <x-input label="Amount" wire:change="calculate" wire:model.lazy="amount" type="" suffix="EUR (€)" money />

                    @if($error_message)
                        <div class="text-red-500 text-sm bg-red-50 p-3 rounded border border-red-200 mb-3">
                            <div class="flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                </svg>
                                {{ $error_message }}
                            </div>
                        </div>
                    @endif

                    <div class="grid grid-cols-1 gap-3">
                        @isset($selectedCountryObject)
                            <x-radio wire:change="calculate" option-value="value" option-name="name"
                                label="Select VAT Rate" :options="$rates" wire:model="selectedRate" />

                            <x-radio wire:change="calculate" label="VAT Included?" :options="$vat_options" option-value="value"
                                option-label="name" wire:model="vat_included" hint="Choose wisely" class="bg-blue-50" />
                        @endisset
                    </div>

                    @if ($total && !$error_message)
                        <div class="results text-lg bg-gray-50 rounded p-3">
                            <div class="text-gray-700">
                                @if ($vat_included == 'include')
                                    Base amount : {{ is_numeric($amount) ? Number::currency((float)$amount, 'EUR') : '0.00 €' }}
                                    <div class="mt-1">
                                        + VAT ({{ is_numeric($selectedRate) ? $selectedRate : '0' }}%): 
                                        {{ is_numeric($vat_amount) ? Number::currency((float)$vat_amount, 'EUR') : '0.00 €' }}
                                    </div>
                                @else
                                    Net amount : {{ is_numeric($amount) ? Number::currency((float)$amount, 'EUR') : '0.00 €' }}
                                    <div class="mt-1">
                                        - VAT ({{ is_numeric($selectedRate) ? $selectedRate : '0' }}%): 
                                        {{ is_numeric($vat_amount) ? Number::currency((float)$vat_amount, 'EUR') : '0.00 €' }}
                                    </div>
                                @endif
                            </div>

                            <div class="pt-3 border-t mt-3">
                                @if ($vat_included == 'include')
                                    Total with VAT included:
                                @else
                                    Total with VAT excluded:
                                @endif
                                <div class='text-2xl font-bold mt-2'>
                                    {{ is_numeric($total) ? Number::currency((float)$total, 'EUR') : '0.00 €' }}
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <x-slot:actions>
                <x-button label="Save calculation" class="btn-outline" wire:click="saveSearch" />
                <x-button label="Calculate" class="btn-primary" type="submit" />
            </x-slot:actions>
        </x-form>
    </div>
</div>


