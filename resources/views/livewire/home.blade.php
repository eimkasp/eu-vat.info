@section('seo')
    <x-seo-meta 
        title="EU VAT Info - VAT Rates Calculator & Information for All EU Countries"
        description="Current VAT rates for all 27 EU countries. Free online calculator, historical data from 2000, rate change alerts, and compliance guides. Updated daily."
        type="website"
    >
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
 <div class="sm:text-center">
                    <h1 class="text-3xl font-bold">
                        Value-Added Tax (VAT) Rates in the European Union
                    </h1>
                    <p class="text-gray-500 dark:text-gray-400">
                        Standard VAT rates for goods and services in EU member states
                    </p>
                </div>
    <div class="md:grid md:grid-cols-12 gap-12">
        

        <div class="md:col-span-8 lg:col-span-7">
            <div class="flex flex-col gap-2 bg-white p-6 rounded shadow-xl">
               

                <div class="">


                    {{-- How to implement recently viewed countries --}}
                    <div class="border rounded-lg overflow-hidden">
                        <div class="flex items-center space-x-3 p-3">
                            <div class="relative flex-1">
                                <input wire:model.live="search"
                                    class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50"
                                    placeholder="Search countries or VAT rates" type="search">
                                <div wire:loading wire:target="search" class="absolute right-3 top-2.5 text-gray-400">
                                    <svg class="animate-spin h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                        <div class="border-t">
                            <div class="relative w-full overflow-auto" wire:loading.class="opacity-50" wire:target="search">
                                <table class="w-full caption-bottom text-sm relative transition-opacity duration-200">
                                    <tr
                                        class=" h-12 px-4 text-left align-middle font-medium text-muted-foreground [&amp;:has([role=checkbox])]:pr-0">

                                        <th
                                            class="p-4 align-middle [&amp;:has([role=checkbox])]:pr-0 min-w-[120px] sm:min-w-[200px]">
                                            Country
                                        </th>
                                        <th class="p-4 align-middle [&amp;:has([role=checkbox])]:pr-0">VAT Rate</th>
                                        <th class="p-4 align-middle [&amp;:has([role=checkbox])]:pr-0 min-w-[200px]">
                                            Special Rates
                                        </th>
                                        <th class="p-4 align-middle [&amp;:has([role=checkbox])]:pr-0">Info</th>
                                    </tr>
                                    <tbody class="[&amp;_tr:last-child]:border-0">
                                        @foreach ($euCountries as $key => $country)
                                            <tr
                                                class="hover:bg-gray-100 border-b transition-colors hover:bg-muted/50 data-[state=selected]:bg-muted">

                                                <td class="p-4 align-middle [&amp;:has([role=checkbox])]:pr-0">
                                                    <button 
                                                        wire:click="selectCountry('{{ $country->slug }}')"
                                                        class="font-medium flex items-center gap-6 text-blue-600 hover:underline text-left"
                                                        title="Show {{ $country->name }} calculator">
                                                        {{ $country->name }}
                                                    </button>
                                                </td>
                                                <td class="p-4 align-middle [&amp;:has([role=checkbox])]:pr-0">
                                                    <div>
                                                        <small
                                                            class="text-gray-700  block text-muted-foreground">Standard
                                                            Rate</small>
                                                        {{ $country->standard_rate }}%
                                                    </div>

                                                </td>
                                                <td class="p-4 align-middle [&amp;:has([role=checkbox])]:pr-0">
                                                    <div class="flex gap-3">
                                                        <div>
                                                            <small class="text-muted text-muted">Reduced Rate</small>
                                                            <br>
                                                            {{ $country->reduced_rate }}% @if ($country->super_reduced_rate)
                                                                - {{ $country->super_reduced_rate }}%
                                                            @endif
                                                        </div>
                                                        <div>
                                                            @if ($country->parking_rate)
                                                                <small class="text-muted text-muted">Parking
                                                                    Rate</small> <br>
                                                                {{ $country->parking_rate }}%
                                                        </div>
                                        @endif
                            </div>

                            </td>
                            </td>
                            <td class="p-4 align-middle [&amp;:has([role=checkbox])]:pr-0">
                                <a href="{{ route('vat-calculator.country', $country->slug) }}"
                                   class="text-blue-600 hover:underline text-sm mb-2 block"
                                   title="View full {{ $country->name }} VAT page">
                                    View Details →
                                </a>
                                Rank: #{{ $country->countryRank() }}
                                <img alt="{{ $country->name }} flag" loading="lazy" class="border mb-3 h-6 rounded"
                                    src="https://flagcdn.com/h80/{{ strtolower($country->iso_code) }}.jpg" />
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
