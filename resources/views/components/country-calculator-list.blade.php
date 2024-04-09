<div>
    <h3 class="mb-6">
        VAT Calculators by Country
    </h3>
    <div class="sm:col-span-2 grid grid-cols-2 sm:grid-cols-4 flex items-center gap-3">

        @foreach ($countries as $country)
            <div class="">
                <a title="{{ $country->name }} VAT Calculator"
                    wire:navigate="{{ route('vat-calculator.country', $country->slug) }}"
                    href="{{ route('vat-calculator.country', $country->slug) }}"
                    class="flex  items-center gap-3 text-blue-500">
                    {{ $country->name }} VAT Calculator
                </a>
            </div>
        @endforeach
    </div>
</div>
