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
                <div class="mt-6">
                    <div class="relative w-full">
                        <div class="grid sm:grid-cols-12 gap-9">
                            <div class="sm:col-span-12">
                                <x-country-rates :country="$country" />
                            </div>
                            <div class="sm:col-span-4">
                                <x-country-stats :country="$country" />
                            </div>

                            <div class="sm:col-span-8">
                                <livewire:vat-calculator :country="$country" />
                                <x-country-tabs :country="$country" />
                            </div>



                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
