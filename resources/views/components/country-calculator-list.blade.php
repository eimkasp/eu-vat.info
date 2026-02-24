<div class="relative">
    <h3 class="mb-6 font-bold text-xl">VAT Calculators by Country</h3>
    
    <div class="flex overflow-x-auto pb-6 gap-4 snap-x scrollbar-hide -mx-4 px-4 sm:mx-0 sm:px-0">
        @foreach ($countries as $country)
            <a href="{{ route('vat-calculator.country', $country->slug) }}" 
              
               class="flex-none w-64 bg-white p-4 rounded-xl shadow-md border border-gray-100 hover:shadow-lg transition-all hover:-translate-y-1 snap-start group">
               <div class="flex items-center gap-3 mb-3 pb-3 border-b border-gray-50">
                   <img src="https://flagcdn.com/h40/{{ strtolower($country->iso_code) }}.jpg" 
                        alt="{{ $country->name }}" 
                        class="w-8 h-auto rounded shadow-sm">
                   <h4 class="font-bold text-gray-900 group-hover:text-blue-600 transition-colors truncate">{{ $country->name }}</h4>
               </div>
               
               <div class="space-y-2 text-sm text-gray-600">
                   <div class="flex justify-between items-center">
                       <span class="text-xs uppercase tracking-wide text-gray-400">Standard</span>
                       <span class="font-bold text-gray-900 bg-blue-50 text-blue-700 px-2 py-0.5 rounded">{{ $country->standard_rate }}%</span>
                   </div>
                   
                   @if($country->currency_code && $country->currency_code !== 'EUR')
                   <div class="flex justify-between items-center">
                       <span class="text-xs uppercase tracking-wide text-gray-400">Currency</span>
                       <span class="font-medium">{{ $country->currency_code }}</span>
                   </div>
                   @endif
               </div>
               
               <div class="mt-4 text-center">
                   <span class="text-xs font-medium text-blue-600 group-hover:underline">Open Calculator →</span>
               </div>
            </a>
        @endforeach
    </div>
</div>
