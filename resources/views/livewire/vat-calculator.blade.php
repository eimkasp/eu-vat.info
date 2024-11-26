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
                 

             </div>
         @endisset
         <div class="mt-6 bg-white p-6 rounded-xl shadow-xl">
             <livewire:europe-map :activeCountry="$selectedCountryObject" />
         </div>

         <div class="mt-6">
                     <a href="{{ route('widget.embed', $selectedCountryObject->slug) }}" class="text-blue-500">Embed this
                         calculator on your website</a>
                        <br>
                     <a wire:navigate="{{ route('country.show', $selectedCountryObject->slug) }}"
                         href="{{ route('country.show', $selectedCountryObject->slug) }}" class="text-blue-500">
                         Learn More about VAT in
                         {{ $selectedCountryObject->name }}</a>
                 </div>

     </div>
     <livewire:vat-calculator-form :slug="$selectedCountryObject->slug" />

     <div class="sm:col-span-2">
         <x-saved-searches></x-saved-searches>
     </div>


     <div class="sm:col-span-2 pb-9">
         <x-country-calculator-list>
         </x-country-calculator-list>
     </div>
 </div>
