<!--
// v0 by Vercel.
// https://v0.dev/t/0Qin3fO74x9
-->
<div class="grid grid-cols-1 gap-4 md:grid-cols-3 max-w-4xl mx-auto my-8">
    <div>
        <h1 class="text-2xl font-bold mb-4">VAT Calculator</h1>
    </div>
    <div>
        <div class="mb-4"><label for="country" class="block text-sm font-medium mb-1">Country</label><button
                type="button" role="combobox" aria-controls="radix-:rq:" aria-expanded="false" aria-autocomplete="none"
                dir="ltr" data-state="closed" data-placeholder=""
                class="flex h-10 w-full items-center justify-between rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50"
                id="country"><span style="pointer-events: none;">Select Country</span><svg
                    xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="h-4 w-4 opacity-50" aria-hidden="true">
                    <path d="m6 9 6 6 6-6"></path>
                </svg></button></div>
    </div>
    <div>
        <div class="mb-4"><label for="vat-rate" class="block text-sm font-medium mb-1">VAT Rate</label><button
                type="button" role="combobox" aria-controls="radix-:ru:" aria-expanded="false" aria-autocomplete="none"
                dir="ltr" data-state="closed" data-placeholder=""
                class="flex h-10 w-full items-center justify-between rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50"
                id="vat-rate"><span style="pointer-events: none;">21%</span><svg xmlns="http://www.w3.org/2000/svg"
                    width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4 opacity-50"
                    aria-hidden="true">
                    <path d="m6 9 6 6 6-6"></path>
                </svg></button></div>
    </div>
    <div>
        <div class="mb-4"><label for="price-ex-vat" class="block text-sm font-medium mb-1">Price Excl.
                VAT</label><input
                class="flex h-10 w-full rounded-md border border-input px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 bg-yellow-100"
                id="price-ex-vat" placeholder="Enter price"></div>
    </div>
    <div>
        <div class="mb-4"><label class="block text-sm font-medium mb-1">VAT Amount</label>
            <div class="flex items-center"><input
                    class="flex h-10 w-full rounded-md border border-input px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 bg-gray-100 mr-2"
                    placeholder="105.00" readonly=""><span class="text-sm font-medium">EUR</span></div>
        </div>
    </div>
</div>
