<div>
    <div class="bg-white p-6 shadow-xl rounded-xl">
        <div class="container">
            <x-breadcrumbs :items="['VAT Map' => '']" />
            
            <div class="max-w-3xl mx-auto mb-6">
                <h1 class="text-3xl font-bold mb-3">European VAT Rates Map</h1>
                <p class="text-gray-600">
                    Interactive map showing current standard VAT rates across all 27 EU member states.
                    Hover over any country to preview its rate, or click to see full details and access the calculator.
                </p>
            </div>

            <livewire:europe-map layout="single" />

            {{-- Country Rate Table --}}
            <div class="max-w-4xl mx-auto mt-10">
                <h2 class="text-2xl font-bold mb-4">All EU VAT Rates at a Glance</h2>
                <div class="overflow-x-auto rounded-xl border border-gray-200">
                    <table class="w-full text-sm">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="text-left px-4 py-3 font-semibold text-gray-700">Country</th>
                                <th class="text-center px-4 py-3 font-semibold text-gray-700">Standard</th>
                                <th class="text-center px-4 py-3 font-semibold text-gray-700">Reduced</th>
                                <th class="text-center px-4 py-3 font-semibold text-gray-700 hidden sm:table-cell">Super Reduced</th>
                                <th class="text-right px-4 py-3 font-semibold text-gray-700">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($countries as $country)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-4 py-2.5">
                                        <a href="{{ route('country.show', $country->slug) }}" wire:navigate class="flex items-center gap-2 text-gray-900 hover:text-blue-600 font-medium">
                                            <img src="https://flagcdn.com/h20/{{ strtolower($country->iso_code) }}.jpg" alt="{{ $country->name }}" class="h-4 rounded border">
                                            {{ $country->name }}
                                        </a>
                                    </td>
                                    <td class="px-4 py-2.5 text-center font-bold text-blue-700">{{ $country->standard_rate }}%</td>
                                    <td class="px-4 py-2.5 text-center text-gray-600">{{ $country->reduced_rate ? $country->reduced_rate . '%' : '—' }}</td>
                                    <td class="px-4 py-2.5 text-center text-gray-600 hidden sm:table-cell">{{ $country->super_reduced_rate ? $country->super_reduced_rate . '%' : '—' }}</td>
                                    <td class="px-4 py-2.5 text-right">
                                        <a href="{{ route('vat-calculator.country', $country->slug) }}" wire:navigate class="text-xs text-blue-600 hover:text-blue-800 font-medium">
                                            Calculator →
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Info cards --}}
            <div class="max-w-4xl mx-auto mt-10">
                <div class="grid md:grid-cols-2 gap-6">
                    <div class="bg-blue-50 p-5 rounded-xl border border-blue-100">
                        <h2 class="text-lg font-bold mb-2 text-blue-900">Understanding EU VAT Rates</h2>
                        <p class="text-gray-600 text-sm mb-3">
                            The EU requires member states to apply a standard VAT rate of at least 15%. Rates range from 17% (Luxembourg) to 27% (Hungary).
                        </p>
                        <ul class="text-sm text-gray-600 space-y-1">
                            <li class="flex items-center gap-2"><span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span>Standard rates: 17% – 27%</li>
                            <li class="flex items-center gap-2"><span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span>Reduced rates for essentials</li>
                            <li class="flex items-center gap-2"><span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span>Special schemes for territories</li>
                        </ul>
                    </div>

                    <div class="bg-gray-50 p-5 rounded-xl border border-gray-200">
                        <h2 class="text-lg font-bold mb-2 text-gray-900">Using the VAT Calculator</h2>
                        <p class="text-gray-600 text-sm mb-3">
                            Click any country on the map above, or use the table to access dedicated VAT tools:
                        </p>
                        <ul class="text-sm text-gray-600 space-y-1">
                            <li class="flex items-center gap-2"><span class="w-1.5 h-1.5 rounded-full bg-gray-500"></span>Calculate inclusive/exclusive VAT</li>
                            <li class="flex items-center gap-2"><span class="w-1.5 h-1.5 rounded-full bg-gray-500"></span>View all applicable rate types</li>
                            <li class="flex items-center gap-2"><span class="w-1.5 h-1.5 rounded-full bg-gray-500"></span>Validate VAT numbers via VIES</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
