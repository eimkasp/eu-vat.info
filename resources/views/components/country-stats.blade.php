   <div class="lg:col-start-3 lg:row-end-1 ">
       <h2 class="sr-only">Summary</h2>
       <div class="rounded-lg bg-gray-800 shadow-sm ring-1 ring-gray-900/5">
           <dl class="grid">
               <div class="flex-auto px-6 pt-6">
                   <div class="flex justify-between items-center align-center">
                       <div>
                           <h2 class="text-lg text-white !mt-0"> {{ $country->name }} </h2>
                       </div>
                       <div>
                           <img class="mb-3 h-9 rounded" src="https://flagcdn.com/h80/{{ strtolower($country->iso_code_2) }}.jpg" />
                       </div>
                   </div>
                   <dt class="text-sm font-semibold leading-6 text-gray-100">
                       Standard VAT rate
                   </dt>
                   <dd class="mt-1 text-base font-semibold leading-6 text-gray-100">
                       {{ $country->standard_rate }}%
                   </dd>
               </div>
               <div class="flex-none self-end px-6 pt-4">
                   <dt class="sr-only">Status</dt>
                   <a href="/" wire:navigate
                       class="hover:bg-green-600 hover:text-white inline-flex items-center rounded-md bg-green-50 px-2 py-1 text-xs font-medium text-green-700 ring-1 ring-inset ring-green-600/20">
                       VAT Rank: {{ $country->countryRank() }}
                   </a>
               </div>
               
           </dl>
           <div class="border-t border-gray-900/5 px-6 py-6">
               <a wire:navigate href="{{ route('country.vat.history', $country->slug) }}"
                   class="text-sm font-semibold leading-6 text-gray-100">
                   See history <small>* Coming soon</small>
                </a>
           </div>
       </div>
   </div>
