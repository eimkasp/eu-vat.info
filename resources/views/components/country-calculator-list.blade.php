<div>
    <h3 class="mb-6">
        VAT Calculators by Country
    </h3>
    <div class="sm:col-span-2 grid grid-cols-2 sm:grid-cols-2 flex items-center gap-3">

        @foreach ($countries as $country)
            <div class="">
                <a title="{{ $country->name }} VAT Calculator"
                    wire:navigate="{{ route('vat-calculator.country', $country->slug) }}"
                    href="{{ route('vat-calculator.country', $country->slug) }}"
                    class="flex  items-center gap-2 text-blue-500">
                    <img alt="{{ $country->name }} flag" loading="lazy" class="border h-8 rounded"
                        src="https://flagcdn.com/h80/{{ strtolower($country->iso_code) }}.jpg" />
                    
                   <div> {{ $country->name }} <br> VAT Calculator </div>
                </a>
            </div>
        @endforeach
    </div>
</div>
