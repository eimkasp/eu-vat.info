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
                                 @if ($vat_included == 'include')
                                     Base amount : {{ Number::currency($amount, 'EUR') }}
                                     <div class="mt-1">
                                         + VAT ({{ $selectedRate }}%): {{ Number::currency($vat_amount, 'EUR') }}
                                     </div>
                                 @else
                                     Net amount : {{ Number::currency($amount, 'EUR') }}
                                     <div class="mt-1">
                                         - VAT ({{ $selectedRate }}%): {{ Number::currency($vat_amount, 'EUR') }}
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
                                     {{ Number::currency($total, 'EUR') }}
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


