<div class="mx-auto max-w-3xl px-4 py-12">
    <div class="flex flex-col gap-2">
        <div class="text-center">
            <h1 class="text-3xl font-bold">
                Value-Added Tax (VAT) Rates in the European Union
            </h1>
            <p class="text-gray-500 dark:text-gray-400">
                Standard VAT rates for goods and services in EU member states
            </p>
        </div>
        <div class="border rounded-lg overflow-hidden">
            <div class="flex items-center space-x-3 p-3">
                <input
                    class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 flex-1"
                    placeholder="Search countries or VAT rates" type="search">
            </div>
            <div class="border-t">
                <div class="relative w-full overflow-auto">
                    <table class="w-full caption-bottom text-sm">
                        <th
                            class="h-12 px-4 text-left align-middle font-medium text-muted-foreground [&amp;:has([role=checkbox])]:pr-0">
                            <tr class="border-b transition-colors hover:bg-muted/50 data-[state=selected]:bg-muted">
                                <td class="p-4 align-middle [&amp;:has([role=checkbox])]:pr-0 min-w-[200px]">Country
                                </td>
                                <td class="p-4 align-middle [&amp;:has([role=checkbox])]:pr-0">VAT Rate</td>
                                <td class="p-4 align-middle [&amp;:has([role=checkbox])]:pr-0">Info</td>
                            </tr>
                        </th>
                        <tbody class="[&amp;_tr:last-child]:border-0">
                            @foreach ($euCountries as $country)
                                <tr class="border-b transition-colors hover:bg-muted/50 data-[state=selected]:bg-muted">
                                    <td class="p-4 align-middle [&amp;:has([role=checkbox])]:pr-0">
                                        <a href="{{ route('country.show', $country->id) }}"
                                            class="text-blue-600 hover:underline">
                                            {{ $country->name }}
                                        </a>
                                    </td>
                                    <td class="p-4 align-middle [&amp;:has([role=checkbox])]:pr-0">
                                        {{ $country->standard_rate }}%</td>
                                    <td class="p-4 align-middle [&amp;:has([role=checkbox])]:pr-0">Standard rate</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
