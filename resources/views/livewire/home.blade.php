<div class="mx-auto max-w-4xl px-4 py-9 sm:py-12 ">
    <div class="flex flex-col gap-2 bg-white p-6 rounded shadow-xl">
        <div class="text-center">
            <h1 class="text-3xl font-bold">
                Value-Added Tax (VAT) Rates in the European Union
            </h1>
            <p class="text-gray-500 dark:text-gray-400">
                Standard VAT rates for goods and services in EU member states
            </p>
        </div>
        {{-- How to implement recently viewed countries --}}
        <div class="border rounded-lg overflow-hidden">
            <div class="flex items-center space-x-3 p-3">
                <input wire:model.live="search"
                    class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 flex-1"
                    placeholder="Search countries or VAT rates" type="search">
            </div>
            <div class="border-t">
                <div class="relative w-full overflow-auto">
                    <table class="w-full caption-bottom text-sm relative">
                        <tr
                            class=" h-12 px-4 text-left align-middle font-medium text-muted-foreground [&amp;:has([role=checkbox])]:pr-0">

                            <th class="p-4 align-middle [&amp;:has([role=checkbox])]:pr-0 min-w-[200px]">Country
                            </th>
                            <th class="p-4 align-middle [&amp;:has([role=checkbox])]:pr-0">VAT Rate</th>
                            <th class="p-4 align-middle [&amp;:has([role=checkbox])]:pr-0 min-w-[200px]">Special Rates
                            </th>
                            <th class="p-4 align-middle [&amp;:has([role=checkbox])]:pr-0">Info</th>
                        </tr>
                        <tbody class="[&amp;_tr:last-child]:border-0">
                            @foreach ($euCountries as $key => $country)
                                <tr
                                    class="hover:bg-gray-100 border-b transition-colors hover:bg-muted/50 data-[state=selected]:bg-muted">

                                    <td class="p-4 align-middle [&amp;:has([role=checkbox])]:pr-0">
                                        <a title="{{ $country->name }} VAT rates"
                                            href="{{ route('country.show', $country->slug) }}"
                                            class="font-medium flex items-center gap-6 text-blue-600 hover:underline">
                                            {{ $country->name }}
                                        </a>
                                    </td>
                                    <td class="p-4 align-middle [&amp;:has([role=checkbox])]:pr-0">
                                        <div>
                                            <small class="text-gray-700  block text-muted-foreground">Standard
                                                Rate</small>
                                            {{ $country->standard_rate }}%
                                        </div>

                                    </td>
                                    <td class="p-4 align-middle [&amp;:has([role=checkbox])]:pr-0">
                                        <div class="flex gap-3">
                                            <div>
                                                <small class="text-muted text-muted">Reduced Rate</small> <br>
                                                {{ $country->reduced_rate }}% @if ($country->super_reduced_rate)
                                                    - {{ $country->super_reduced_rate }}%
                                                @endif
                                            </div>
                                            <div>
                                                @if ($country->parking_rate)
                                                    <small class="text-muted text-muted">Parking Rate</small> <br>
                                                    {{ $country->parking_rate }}%
                                            </div>
                            @endif
                </div>

                </td>
                </td>
                <td class="p-4 align-middle [&amp;:has([role=checkbox])]:pr-0">
                    Rank: #{{ $key + 1 }}
                    <img alt="{{ $country->name }} flag" loading="lazy" class="border mb-3 h-6 rounded"
                        src="https://flagcdn.com/h80/{{ $country->iso_code }}.jpg" />
                </td>
                </tr>
                @endforeach
                </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</div>
