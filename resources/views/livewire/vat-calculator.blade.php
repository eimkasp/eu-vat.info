<div class="container py-12 mt-12 pb-12 sm:grid-cols-2 grid gap-9">
    <div>
        <h1 class="text-2xl font-bold pt-12 mb-3">

            VAT Calculator

            @if ($selectedCountryObject)
                - {{ $selectedCountryObject->name }}
            @endif
        </h1>
        <p>
            This is a simple VAT calculator for {{ $selectedCountryObject->name }}.
            Our goal is to help you calculate the VAT amount
        </p>
        @if ($selectedCountryObject)
            <div class="mb-3">
                <x-country-rates :country="$selectedCountryObject" />
            </div>
            <a wire:navigate="{{ route('country.show', $selectedCountryObject->slug) }}"
                href="{{ route('country.show', $selectedCountryObject->slug) }}" class="text-blue-500">
                Learn More about VAT in
                {{ $selectedCountryObject->name }}</a>
        @endif

    </div>

    <div class="font-medium mt-6">
        <x-form class="bg-blue-50 p-6 rounded shadow-xl" wire:submit="calculate">

            <div class="grid sm:grid-cols-1 gap-3">
                <div class="sm:col-span-6 gap-3 grid">
                    <x-select wire:change="calculate" label="Country" :options="$countries" option-value="slug"
                        option-label="name" placeholder="Select a country" {{-- Set a value for placeholder. Default is `null` --}}
                        wire:model.live="selectedCountry1" />

                    {{-- <x-select label="Country from" :options="$countries" option-value="slug" option-label="name"
                        placeholder="Select a country" placeholder-value="0"
                        hint="Select one, please." wire:model="selectedCountry2" /> --}}
                </div>

                <div class="sm:col-span-6 grid gap-3">
                    <x-input label="Amount" wire:change="calculate" wire:model.live="amount" suffix="EUR (€)" money
                         />

                    <div class="grid grid-cols-1 gap-3">
                        @if ($selectedCountryObject)
                            <x-radio wire:change="calculate" option-value="value" option-name="name"
                                label="Select VAT Rate" :options="$rates" wire:model="selectedRate" />

                            <x-radio wire:change="calculate" label="VAT Included?" :options="$vat_options"
                                option-value="value" option-label="name" wire:model="vat_included" hint="Choose wisely"
                                class="bg-red-50" />
                        @endif


                    </div>
                    @if ($total)
                        <div class="results bg-gray-100 rounded p-3">
                            <div class="text-gray-700">
                                Amount : {{ Number::currency($amount, 'EUR') }}
                            </div>
                            @if ($vat_included == 'include')
                                +
                            @else
                            @endif
                            {{ Number::currency($vat_amount, 'EUR') }} (VAT - {{ $selectedRate }}%)

                            <div>

                            </div>
                            <div class="text-xl">
                                @if ($vat_included == 'include')
                                    Total with VAT included: {{ Number::currency($total, 'EUR') }}
                                @else
                                    Total with VAT excluded: {{ Number::currency($total, 'EUR') }}
                                @endif
                            </div>
                        </div>
                    @endif


                </div>
            </div>




            <x-slot:actions>
                <x-button label="Save calculation" class="btn-outline" wire:click="saveSearch" />

                <x-button label="Calculate" class="btn-primary" type="submit" />
            </x-slot:actions>


        </x-form>



    </div>
    <div class="sm:col-span-2">
        @if ($saved_searches)
            @if (count($saved_searches) > 0)
                <div class="pb-9 pt-9">
                    <div class="flex justify-between mb-6">
                        <h3>Saved Calculations ({{ count($saved_searches) }}) </h3>

                        <div class="ml-4">
                            <x-button label="Clear" class="btn-outline" wire:click="clearSearch" />
                        </div>
                    </div>
                    @if ($saved_searches)
                        <div class="grid grid-cols-4 gap-6">
                            @foreach ($saved_searches as $search)
                                @php
                                    $saved_country = $countries->where('slug', $search['selectedCountry1'])->first();
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
</div>
