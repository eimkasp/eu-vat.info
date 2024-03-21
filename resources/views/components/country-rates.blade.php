<dl class="mx-auto grid grid-cols-1 gap-px bg-gray-900/5 sm:grid-cols-2 lg:grid-cols-4">
    <div class="flex flex-wrap items-baseline justify-between gap-x-4 gap-y-2 bg-white px-4 py-6 sm:px-6 xl:px-8 !pl-0">
        <dt class="text-sm font-medium leading-6 text-gray-500">Standard Rate</dt>
        <dd class="text-xs font-medium text-gray-700">Rank: {{ $country->countryRank() }}</dd>
        <dd class="w-full flex-none text-3xl font-medium leading-10 tracking-tight text-gray-900">
            {{ $country->standard_rate }}%
        </dd>
    </div>
    <div class="flex flex-wrap items-baseline justify-between gap-x-4 gap-y-2 bg-white px-4 py-6 sm:px-6 xl:px-8">
        <dt class="text-sm font-medium leading-6 text-gray-500">Reduced Rate</dt>
        <dd class="text-xs font-medium text-rose-600">+54.02%</dd>
        <dd class="w-full flex-none text-3xl font-medium leading-10 tracking-tight text-gray-900">
            {{ $country->reduced_rate }}%
        </dd>
    </div>
    <div class="flex flex-wrap items-baseline justify-between gap-x-4 gap-y-2 bg-white px-4 py-6 sm:px-6 xl:px-8">
        <dt class="text-sm font-medium leading-6 text-gray-500">Super reduced rate</dt>
        <dd class="text-xs font-medium text-gray-700">-1.39%</dd>
        <dd class="w-full flex-none text-3xl font-medium leading-10 tracking-tight text-gray-900">
            {{ isset($country->super_reduced_rate) ? $country->super_reduced_rate . '%' : 'N/A' }}        </dd>
    </div>
    <div class="flex flex-wrap items-baseline justify-between gap-x-4 gap-y-2 bg-white px-4 py-6 sm:px-6 xl:px-8">
        <dt class="text-sm font-medium leading-6 text-gray-500">
            Parking Rate
        </dt>
        <dd class="text-xs font-medium text-rose-600">+10.18%</dd>
        <dd class="w-full flex-none text-3xl font-medium leading-10 tracking-tight text-gray-900">
            {{ isset($country->parking_rate) ? $country->parking_rate . '%' : 'N/A' }}        </dd>
        </dd>
    </div>
</dl>
