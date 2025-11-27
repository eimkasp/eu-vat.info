@section('seo')
    <x-seo-meta title="EU VAT Info - VAT Rates Calculator & Information for All EU Countries"
        description="Current VAT rates for all 27 EU countries. Free online calculator, historical data from 2000, rate change alerts, and compliance guides. Updated daily."
        type="website">
        <script type="application/ld+json">
        {
            "@context": "https://schema.org",
            "@type": "WebSite",
            "name": "EU VAT Info",
            "url": "{{ url('/') }}",
            "description": "VAT rates and calculator for all EU countries",
            "potentialAction": {
                "@type": "SearchAction",
                "target": {
                    "@type": "EntryPoint",
                    "urlTemplate": "{{ url('/') }}?search={search_term_string}"
                },
                "query-input": "required name=search_term_string"
            }
        }
        </script>
    </x-seo-meta>
@endsection

<div class="mx-auto max-w-7xl px-4 py-6 sm:py-12" x-data="{ showMap: true }">
    <div class="text-center mb-16 max-w-3xl mx-auto">
        <h1 class="text-4xl sm:text-5xl font-extrabold text-gray-900 tracking-tight mb-4">
            VAT Rates in the <span class="text-blue-600">European Union</span>
        </h1>
        <p class="text-xl text-gray-500 leading-relaxed">
            Current standard VAT rates, reduced rates, and calculator for all 27 EU member states. Updated daily.
        </p>
    </div>

    <div class="md:grid md:grid-cols-12 gap-12">


        <div class="md:col-span-8 lg:col-span-7">
            <div class="flex flex-col gap-2 bg-white rounded shadow-xl">


                <div class="">


                    <div class="bg-white border border-gray-100 rounded-2xl shadow-sm overflow-hidden">
                        <div class="p-4 border-b border-gray-100 bg-gray-50/50">
                            <div class="relative">
                                <input wire:model.live="search"
                                    class="w-full pl-10 pr-4 py-3 rounded-xl border-0 ring-1 ring-gray-200 focus:ring-2 focus:ring-blue-500 bg-white shadow-sm transition-all"
                                    placeholder="Search for a country..." type="search">
                                <div class="absolute left-3 top-3.5 text-gray-400">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                                    </svg>
                                </div>
                                <div wire:loading wire:target="search" class="absolute right-3 top-3.5 text-blue-500">
                                    <svg class="animate-spin h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none"
                                        viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10"
                                            stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor"
                                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                        </path>
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <div class="overflow-x-auto" wire:loading.class="opacity-50" wire:target="search">
                            <table class="w-full text-left text-sm text-gray-600">
                                <thead class="bg-gray-50 text-xs uppercase font-semibold text-gray-500 tracking-wider">
                                    <tr>
                                        <th class="px-6 py-4">Country</th>
                                        <th class="px-6 py-4">Standard Rate</th>
                                        <th class="px-6 py-4 hidden sm:table-cell">Reduced</th>
                                        <th class="px-6 py-4 text-right">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100">
                                    @foreach ($euCountries as $country)
                                        <tr class="hover:bg-blue-50/50 transition-colors group">
                                            <td class="px-6 py-4">
                                                <button wire:click="selectCountry('{{ $country->slug }}')"
                                                    class="flex items-center gap-4 group-hover:text-blue-600 transition-colors">
                                                    <span
                                                        class="font-mono text-xs text-gray-300 w-6">#{{ $country->countryRank() }}</span>
                                                    <img src="https://flagcdn.com/h40/{{ strtolower($country->iso_code) }}.jpg"
                                                        alt="{{ $country->name }}"
                                                        class="h-6 w-auto rounded-sm shadow-sm">
                                                    <span
                                                        class="font-bold text-gray-900 group-hover:text-blue-600">{{ $country->name }}</span>
                                                </button>
                                            </td>
                                            <td class="px-6 py-4">
                                                <span
                                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-sm font-bold bg-blue-100 text-blue-800">
                                                    {{ $country->standard_rate }}%
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 hidden sm:table-cell">
                                                @if ($country->reduced_rate)
                                                    <span class="text-gray-500">{{ $country->reduced_rate }}%</span>
                                                    @if ($country->super_reduced_rate)
                                                        <span
                                                            class="text-gray-400 text-xs ml-1">({{ $country->super_reduced_rate }}%)</span>
                                                    @endif
                                                @else
                                                    <span class="text-gray-300">-</span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 text-right">
                                                <a href="{{ route('vat-calculator.country', $country->slug) }}"
                                                    class="text-blue-600 font-medium hover:text-blue-800 text-xs uppercase tracking-wide transition-colors">
                                                    Details &rarr;
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
         <div class="md:col-span-4 lg:col-span-5">
            <!-- Calculator Widget -->
            <div class="mb-6">
                @if($selectedCountry)
                    <livewire:vat-calculator-form :slug="$selectedCountry->slug" :key="'calc-'.$selectedCountry->id" />
                    
                    <div class="mt-2 pt-2 border-t">
                        <a href="{{ route('vat-calculator.country', $selectedCountry->slug) }}" 
                           class="text-blue-600 hover:underline text-sm">
                            View full calculator & history →
                        </a>
                    </div>
                @endif
            </div>
            
            <!-- VAT Rate Changes Widget -->
            <livewire:vat-rate-changes />
            
            <!-- Sidebar Banners -->
            <x-banner-display position="sidebar" />
            
            <!-- Useful Links Widget -->
            <x-useful-vat-links />
            
            <!-- Recent Countries & Map -->
            <div>
                <livewire:recent-countries />
                <div class="bg-white p-6 shadow-xl rounded-xl">
                    <livewire:europe-map />
                </div>
            </div>
        </div>
    </div>



</div>


</div>
