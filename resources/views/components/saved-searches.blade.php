 <div>
     @if ($saved_searches)
         @if (count($saved_searches) > 0)
             <div class="pb-9 pt-9">
                 <div class="flex justify-between items-center mb-6">
                     <h3>Saved Calculations ({{ count($saved_searches) }}) </h3>

                     <div class="">
                         <x-button label="Clear" class="btn-outline" wire:click="clearSearch" />
                     </div>
                 </div>
                 @if ($saved_searches)
                     <div class="grid sm:grid-cols-4 gap-6">
                         @foreach ($saved_searches as $search)
                             @php
                                 $saved_country = App\Models\Country::where('slug', $search['selectedCountry1'])->first();
                                 $saved_link = route('vat-calculator', [
                                     'selectedCountry1' => $search['selectedCountry1'],
                                     'amount' => $search['amount'],
                                     'selectedRate' => $search['selectedRate'],
                                     'vat_included' => $search['vat_included'],
                                 ]);
                             @endphp
                             <a href="{{ $saved_link }}" wire.navigate="{{ $saved_link }}">
                                 <div class="card p-6 bg-white shadow-xl">
                                     {{ $saved_country->name }}
                                     <div class="text-sm text-green-600">
                                         {{ Number::currency($search['amount'], 'EUR') }}
                                         ({{ $search['selectedRate'] }}%)
                                         -
                                         {{ $search['vat_included'] }}
                                     </div>
                                 </div>
                             </a>
                         @endforeach
                     </div>
                 @endif

             </div>
         @else
             Your saved searches will appear here.
         @endif
     @endif
 </div>
