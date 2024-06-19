<div>
   <div class="font-medium">
         <x-form class="bg-blue-50 p-6 rounded shadow-xl" wire:submit="calculate">
             <div class="grid sm:grid-cols-1 gap-3">
                 <div class="sm:col-span-6 gap-3 grid">
                     <x-select wire:change="calculate" label="Country" :options="$countries" option-value="slug"
                         option-label="name" placeholder="Select a country" {{-- Set a value for placeholder. Default is `null` --}}
                         wire:model.live="selectedCountry1" />
                     {{-- <x-select label="Country from" :options="$countries" option-value="slug" option-label="name"
                        placeholder="Select a country" placeholder-value="0"
                        hint="Select one, please." wire:model="selectedCountry2" /> --}}
                 </div>

                 <div class="sm:col-span-6 grid gap-3">
                     <x-input label="Amount" wire:change="calculate" wire:model.live="amount" suffix="EUR (€)" money />

                     <div class="grid grid-cols-1 gap-3">
                         @isset($selectedCountryObject)
                             <x-radio wire:change="calculate" option-value="value" option-name="name"
                                 label="Select VAT Rate" :options="$rates" wire:model="selectedRate" />

                             <x-radio wire:change="calculate" label="VAT Included?" :options="$vat_options" option-value="value"
                                 option-label="name" wire:model="vat_included" hint="Choose wisely" class="bg-blue-50" />
                         @endisset


                     </div>
                     @if ($total)
                         <div class="results text-lg bg-gray-50 rounded p-3">
                             <div class="text-gray-700">
                                 Starting amount : {{ Number::currency($amount, 'EUR') }}
                             </div>
                             @if ($vat_included == 'include')
                                 +
                             @else
                             @endif
                             {{ Number::currency($vat_amount, 'EUR') }} <span class="text-sm text-gray-800">(VAT:
                                 {{ $selectedRate }}%) </span>

                             <div>

                             </div>
                             <div class="pt-3 border-t mt-3">
                                 @if ($vat_included == 'include')
                                     Total with VAT included:
                                 @else
                                     Total with VAT excluded:
                                 @endif
                                 <div class='text-2xl font-bold mt-2 '>
                                     {{ Number::currency($total, 'EUR') }}
                                 </div>
                             </div>
                         </div>
                     @endif


                 </div>
             </div>




             <x-slot:actions>
                 <x-button label="Save calculation" class="btn-outline plausible-event-name=Save" wire:click="saveSearch" />

                 <x-button label="Calculate" class="btn-primary plausible-event-name=Calculate" type="submit" />
             </x-slot:actions>


         </x-form>



     </div>

    {{-- To attain knowledge, add things every day; To attain wisdom, subtract things every day. --}}
</div>
