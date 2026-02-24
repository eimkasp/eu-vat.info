<div>
    <div class="bg-white p-6 shadow-xl rounded-xl">
        <div class="container">
            <x-breadcrumbs :items="[__('ui.breadcrumbs.vat_map') => '']" />
            
            <div class="max-w-3xl mx-auto mb-6">
                <h1 class="text-3xl font-bold mb-3">{{ __('ui.map.title') }}</h1>
                <p class="text-gray-600">
                    {{ __('ui.map.subtitle') }}
                </p>
            </div>

            <livewire:europe-map layout="single" />

            {{-- Country Rate Table --}}
            <div class="max-w-4xl mx-auto mt-10">
                <h2 class="text-2xl font-bold mb-4">{{ __('ui.map.all_rates') }}</h2>
                <div class="overflow-x-auto rounded-xl border border-gray-200">
                    <table class="w-full text-sm">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="text-left px-4 py-3 font-semibold text-gray-700">{{ __('ui.map.th_country') }}</th>
                                <th class="text-center px-4 py-3 font-semibold text-gray-700">{{ __('ui.map.th_standard') }}</th>
                                <th class="text-center px-4 py-3 font-semibold text-gray-700">{{ __('ui.map.th_reduced') }}</th>
                                <th class="text-center px-4 py-3 font-semibold text-gray-700 hidden sm:table-cell">{{ __('ui.map.th_super_reduced') }}</th>
                                <th class="text-right px-4 py-3 font-semibold text-gray-700">{{ __('ui.actions') }}</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($countries as $country)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-4 py-2.5">
                                        <a href="{{ locale_path('/country/' . $country->slug) }}" class="flex items-center gap-2 text-gray-900 hover:text-blue-600 font-medium">
                                            <img src="https://flagcdn.com/h20/{{ strtolower($country->iso_code) }}.jpg" alt="{{ $country->name }}" class="h-4 rounded border">
                                            {{ $country->name }}
                                        </a>
                                    </td>
                                    <td class="px-4 py-2.5 text-center font-bold text-blue-700">{{ $country->standard_rate }}%</td>
                                    <td class="px-4 py-2.5 text-center text-gray-600">{{ $country->reduced_rate ? $country->reduced_rate . '%' : '—' }}</td>
                                    <td class="px-4 py-2.5 text-center text-gray-600 hidden sm:table-cell">{{ $country->super_reduced_rate ? $country->super_reduced_rate . '%' : '—' }}</td>
                                    <td class="px-4 py-2.5 text-right">
                                        <a href="{{ locale_path('/vat-calculator/' . $country->slug) }}" class="text-xs text-blue-600 hover:text-blue-800 font-medium">
                                            {{ __('ui.map.calculator_link') }} →
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Info cards --}}
            <div class="max-w-4xl mx-auto mt-10">
                <div class="grid md:grid-cols-2 gap-6">
                    <div class="bg-blue-50 p-5 rounded-xl border border-blue-100">
                        <h2 class="text-lg font-bold mb-2 text-blue-900">{{ __('ui.map.understanding') }}</h2>
                        <p class="text-gray-600 text-sm mb-3">
                            {{ __('ui.map.understanding_desc') }}
                        </p>
                        <ul class="text-sm text-gray-600 space-y-1">
                            <li class="flex items-center gap-2"><span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span>{{ __('ui.map.standard_range') }}</li>
                            <li class="flex items-center gap-2"><span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span>{{ __('ui.map.reduced_essentials') }}</li>
                            <li class="flex items-center gap-2"><span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span>{{ __('ui.map.special_schemes') }}</li>
                        </ul>
                    </div>

                    <div class="bg-gray-50 p-5 rounded-xl border border-gray-200">
                        <h2 class="text-lg font-bold mb-2 text-gray-900">{{ __('ui.map.using_calculator') }}</h2>
                        <p class="text-gray-600 text-sm mb-3">
                            {{ __('ui.map.using_calc_desc') }}
                        </p>
                        <ul class="text-sm text-gray-600 space-y-1">
                            <li class="flex items-center gap-2"><span class="w-1.5 h-1.5 rounded-full bg-gray-500"></span>{{ __('ui.map.calc_inclusive') }}</li>
                            <li class="flex items-center gap-2"><span class="w-1.5 h-1.5 rounded-full bg-gray-500"></span>{{ __('ui.map.view_rate_types') }}</li>
                            <li class="flex items-center gap-2"><span class="w-1.5 h-1.5 rounded-full bg-gray-500"></span>{{ __('ui.map.validate_vat') }}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
