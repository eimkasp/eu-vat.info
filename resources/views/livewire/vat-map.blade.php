<div>
    <div class="bg-white p-6 shadow-xl rounded-xl">
        <div class="container">
            <x-breadcrumbs :items="['VAT Map' => '']" />
            <livewire:europe-map layout="single" />
            <div class="max-w-3xl mx-auto mb-8">
                <h1 class="text-3xl font-bold mb-4">European VAT Rates Map</h1>
                <div class="prose">
                    <p class="text-gray-600 mb-4">
                        Explore current Value Added Tax (VAT) rates across Europe with our interactive map. This visual
                        guide helps businesses and individuals understand the different standard and reduced VAT rates
                        applied in European Union member states.
                    </p>
                    <p class="text-gray-600 mb-4">
                        Standard VAT rates in the EU range from 17% to 27%, with most countries applying reduced rates
                        for specific goods and services. Hover over or click on any country to see detailed VAT
                        information and access our VAT calculator.
                    </p>
                    <div class="bg-blue-50 p-4 rounded-lg mb-6">
                        <h2 class="text-lg font-semibold mb-2">Key Features:</h2>
                        <ul class="list-disc list-inside text-gray-600">
                            <li>Interactive visualization of European VAT rates</li>
                            <li>Quick access to country-specific VAT information</li>
                            <li>Standard and reduced rates for each country</li>
                            <li>Direct links to VAT calculators</li>
                        </ul>
                    </div>
                </div>
            </div>

            {{-- Additional content below map --}}
            <div class="max-w-4xl mx-auto mt-12">
                <div class="grid md:grid-cols-2 gap-8">
                    <div class="bg-white p-6 rounded-lg shadow-md">
                        <h2 class="text-2xl font-bold mb-4">Understanding EU VAT Rates</h2>
                        <p class="text-gray-600 mb-4">
                            The European Union's VAT system requires member states to apply a standard VAT rate of at
                            least 15%. Countries can also implement reduced rates for specific categories of goods and
                            services.
                        </p>
                        <ul class="list-disc list-inside text-gray-600 space-y-2">
                            <li>Standard rates vary from 17% to 27%</li>
                            <li>Reduced rates for essential goods</li>
                            <li>Special schemes for certain territories</li>
                            <li>Regular updates to comply with EU directives</li>
                        </ul>
                    </div>

                    <div class="bg-white p-6 rounded-lg shadow-md">
                        <h2 class="text-2xl font-bold mb-4">Using the VAT Calculator</h2>
                        <p class="text-gray-600 mb-4">
                            Our VAT calculator helps you quickly compute VAT amounts for any EU country. Simply click on
                            a country in the map above to:
                        </p>
                        <ul class="list-disc list-inside text-gray-600 space-y-2">
                            <li>Calculate VAT inclusive/exclusive amounts</li>
                            <li>View all applicable VAT rates</li>
                            <li>Save calculations for future reference</li>
                            <li>Access country-specific VAT rules</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
