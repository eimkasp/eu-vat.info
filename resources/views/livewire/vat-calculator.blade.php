<div>
    <form>
    {{-- Add country select --}}
    <div class="col-span-1">
        <label for="country" class="block text-sm font-medium text-gray-700">Country</label>
        <select id="country" name="country" wire:model="country"
            class="mt-1 focus
                :ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
            <option value="">Select a country</option>
            @foreach ($countries as $country)
                <option value="{{ $country->id }}">{{ $country->name }}</option>
            @endforeach
        </select>
    </div>
    
        <div class="grid grid-cols-1 gap-6">
            <div class="col-span-1">
                <label for="amount" class="block text-sm font-medium text-gray-700">Amount</label>
                <input type="number" name="amount" id="amount" wire:model="amount"
                    class="mt-1 focus
                :ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
            </div>
            <div class="col-span-1">
                <label for="vat" class="block text-sm font-medium text-gray-700">VAT</label>
                <input type="number" name="vat" id="vat" wire:model="vat"
                    class="mt-1 focus
                :ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
            </div>
            <div class="col-span-1">
                <label for="total" class="block text-sm font-medium text-gray-700">Total</label>
                <input type="number" name="total" id="total" wire:model="total"
                    class="mt-1 focus
                :ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
            </div>
        </div>

    </form>
</div>
