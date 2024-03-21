<div class="mx-auto max-w-7xl py-6">
    <div>
        <div>
            <div class="mx-auto max-w-6xl py-6">
                <div class="space-y-3">
                    <h1 class="text-3xl font-bold">
                        {{ $country->name }}
                    </h1>
                    <p class="text-gray-500 dark:text-gray-400">
                        VAT rates for goods and services in {{ $country->name }}
                    </p>
                </div>
                <div class="">
                    <div class="relative w-full">
                        <div class="grid sm:grid-cols-12 gap-9">
                            <div class="sm:col-span-12">
                                {{-- <x-country-rates :country="$country" /> --}}
                            </div>
                            <div class="sm:col-span-4">
                                <x-country-stats :country="$country" />

                                
                            </div>

                            <div class="sm:col-span-8">
                                <div class="mb-6">
                                    <x-country-rates :country="$country" />
                                </div>

                                <div class="mb-3">
                                    <h3 class="text-xl font-medium">
                                        {{ $country->name }} VAT Exceptions
                                    </h3>
                                    <ul>
                                        <li>
                                            Medical and dental care Exempt
                                        </li>
                                    </ul>
                                </div>

                                <div class="mb-3">
                                    <h3 class="text-xl font-medium">
                                        {{ $country->name }} VAT Reduced rates
                                    </h3>
                                    <ul>
                                        <li>
                                            Foodstuffs 5%
                                        </li>
                                        <li>
                                            Books 5%
                                        </li>
                                        <li>
                                            Pharmaceuticals 5%
                                        </li>
                                        
                                    </ul>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="hidden mt-9">
                    <h3 class="text-xl font-medium mb-3">Related countries</h3>
                    <x-related-countries :country="$country" />

                </div>
            </div>

        </div>

    </div>
</div>
