 @isset($selectedCountryObject)
     @section('title', 'VAT Calculator - ' . $selectedCountryObject->name)
 @section('meta_description',
     'Calculate VAT amount for ' .
     $selectedCountryObject->name .
     '. Use our VAT
     calculator to easily calculate VAT for transactions in ' .
     $selectedCountryObject->name .
     '.')
 @else
 @section('title', 'VAT Calculator - EU-VAT.info')
 @section('meta_description',
     'Calculate VAT amount for different countries. Use our VAT
     calculator to easily calculate VAT for transactions in different countries.')
 @endisset

 <div class="container py-12 mt-12 pb-12 sm:grid-cols-2 grid gap-9">
     <div>
         <h1 class="text-4xl font-bold pt-12 sm:mb-3">

             VAT Calculator

             @isset($selectedCountryObject)
                 - {{ $selectedCountryObject->name }}
             @endisset
         </h1>
         <h2 class="text-xl">
             @isset($selectedCountryObject)
                 {{ Number::currency($amount, 'EUR') }} with VAT @if ($vat_included == 'include')
                     included
                 @else
                     excluded
                 @endif

                 In {{ $selectedCountryObject->name }}
                 @if ($total)
                     = {{ Number::currency($total, 'EUR') }}
                 @endif
             @endisset
         </h2>
         @isset($selectedCountryObject)
             <p class="">
                 This is a simple VAT calculator for {{ $selectedCountryObject->name }}.
                 Our goal is to help you calculate the VAT amount for transactions in {{ $selectedCountryObject->name }}.
             </p>
         @else
             <p class="">
                 This is a simple VAT calculator.
                 Our goal is to help you calculate the VAT amount for transactions in different countries.
             </p>
         @endisset
         @isset($selectedCountryObject)
             {{-- Desktop only --}}
             <div class="hidden sm:block">
                 <div class="mb-3">
                     <x-country-rates :country="$selectedCountryObject" />
                 </div>
                 <a wire:navigate="{{ route('country.show', $selectedCountryObject->slug) }}"
                     href="{{ route('country.show', $selectedCountryObject->slug) }}" class="text-blue-500">
                     Learn More about VAT in
                     {{ $selectedCountryObject->name }}</a>
             </div>
         @endisset

     </div>

     <div class="font-medium sm:mt-6">
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
                 <x-button label="Save calculation" class="btn-outline" wire:click="saveSearch" />

                 <x-button label="Calculate" class="btn-primary" type="submit" />
             </x-slot:actions>


         </x-form>



     </div>
     <div class="sm:col-span-2">
         <x-saved-searches></x-saved-searches>
     </div>
     <div class="sm:col-span-2 pb-9">
         <x-country-calculator-list>
         </x-country-calculator-list>
     </div>

     <div class="sm:col-span-2 pb-9">
         @isset($selectedCountryObject)
             <x-vat-history :country="$selectedCountryObject">
             </x-vat-history>
         @endisset
     </div>
 </div>
