<div x-data="{
    tabSelected: 1,
    tabId: $id('tabs'),
    tabButtonClicked(tabButton) {
        this.tabSelected = tabButton.id.replace(this.tabId + '-', '');
        this.tabRepositionMarker(tabButton);
    },
    tabRepositionMarker(tabButton) {
        this.$refs.tabMarker.style.width = tabButton.offsetWidth + 'px';
        this.$refs.tabMarker.style.height = tabButton.offsetHeight + 'px';
        this.$refs.tabMarker.style.left = tabButton.offsetLeft + 'px';
    },
    tabContentActive(tabContent) {
        return this.tabSelected == tabContent.id.replace(this.tabId + '-content-', '');
    }
}" x-init="tabRepositionMarker($refs.tabButtons.firstElementChild);" class="relative w-full ">

    <div x-ref="tabButtons"
        class="relative inline-grid items-center justify-center w-full h-10 grid-cols-2 p-1 text-gray-500 bg-gray-100 rounded-lg select-none">
        <button :id="$id(tabId)" @click="tabButtonClicked($el);" type="button"
            class="relative z-20 inline-flex items-center justify-center w-full h-8 px-3 text-sm font-medium transition-all rounded-md cursor-pointer whitespace-nowrap">
            VAT Rates
        </button>
        <button :id="$id(tabId)" @click="tabButtonClicked($el);" type="button"
            class="relative z-20 inline-flex items-center justify-center w-full h-8 px-3 text-sm font-medium transition-all rounded-md cursor-pointer whitespace-nowrap">
            VAT History
        </button>
        <div x-ref="tabMarker" class="absolute left-0 z-10 w-1/2 h-full duration-300 ease-out" x-cloak>
            <div class="w-full h-full bg-white rounded-md shadow-sm"></div>
        </div>
    </div>
    <div class="relative w-full mt-2 content">
        <div :id="$id(tabId + '-content')" x-show="tabContentActive($el)" class="relative">
            <!-- Tab Content 1 - Replace with your content -->
            <div>
                <h3 class="text-base font-semibold leading-6 text-gray-900">Available VAT rates</h3>
                <dl class="mt-5 grid grid-cols-1 gap-5 sm:grid-cols-3">
                    <div class="overflow-hidden rounded-lg bg-white px-4 py-5 shadow sm:p-6">
                        <dt class="truncate text-sm font-medium text-gray-500">Standard rate</dt>
                        <dd class="mt-1 text-3xl font-semibold tracking-tight text-gray-900">
                            {{ $country->standard_rate }}%
                        </dd>
                    </div>
                    <div class="overflow-hidden rounded-lg bg-white px-4 py-5 shadow sm:p-6">
                        <dt class="truncate text-sm font-medium text-gray-500">Avg. Open Rate</dt>
                        <dd class="mt-1 text-3xl font-semibold tracking-tight text-gray-900">58.16%</dd>
                    </div>
                    <div class="overflow-hidden rounded-lg bg-white px-4 py-5 shadow sm:p-6">
                        <dt class="truncate text-sm font-medium text-gray-500">Avg. Click Rate</dt>
                        <dd class="mt-1 text-3xl font-semibold tracking-tight text-gray-900">24.57%</dd>
                    </div>
                </dl>
            </div>

            <!-- End Tab Content 1 -->
        </div>

        <div :id="$id(tabId + '-content')" x-show="tabContentActive($el)" class="relative" x-cloak>
            <!-- Tab Content 2 - Replace with your content -->
            <div class="border rounded-lg shadow-sm bg-card text-neutral-900">
                <div class="flex flex-col space-y-1.5 p-6">
                    <h3 class="text-lg font-semibold leading-none tracking-tight">Password</h3>
                    <p class="text-sm text-neutral-500">Change your password here. After saving, you'll be logged out.
                    </p>
                </div>
                <div class="p-6 pt-0 space-y-2">
                    <div class="space-y-1"><label
                            class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70"
                            for="password">Current Password</label><input type="password" placeholder="Current Password"
                            id="password"
                            class="flex w-full h-10 px-3 py-2 text-sm bg-white border rounded-md peer border-neutral-300 ring-offset-background placeholder:text-neutral-400 focus:border-neutral-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-neutral-400 disabled:cursor-not-allowed disabled:opacity-50" />
                    </div>
                    <div class="space-y-1"><label
                            class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70"
                            for="password_new">New Password</label><input type="password" placeholder="New Password"
                            id="password_new"
                            class="flex w-full h-10 px-3 py-2 text-sm bg-white border rounded-md border-neutral-300 ring-offset-background placeholder:text-neutral-400 focus:border-neutral-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-neutral-400 disabled:cursor-not-allowed disabled:opacity-50" />
                    </div>
                </div>
                <div class="flex items-center p-6 pt-0"><button type="button"
                        class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium tracking-wide text-white transition-colors duration-200 rounded-md bg-neutral-950 hover:bg-neutral-900 focus:ring-2 focus:ring-offset-2 focus:ring-neutral-900 focus:shadow-outline focus:outline-none">Save
                        password</button></div>
            </div>
            <!-- End Tab Content 2 -->
        </div>

    </div>
</div>
