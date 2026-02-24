<div class="relative"
 x-data="{
                hoveredCountry: null,
                selectedCountry: @if($activeCountry) {{ json_encode($countryData[strtoupper($activeCountry->iso_code)] ?? null) }} @else null @endif,
                mouseX: 0,
                mouseY: 0,
                countryData: @entangle('countryData'),
                getColor(rate) {
                    if (!rate) return '#e5e7eb';
                    if (rate >= 25) return '#7c3aed';
                    if (rate >= 23) return '#2563eb';
                    if (rate >= 21) return '#0891b2';
                    if (rate >= 20) return '#059669';
                    if (rate >= 19) return '#65a30d';
                    if (rate < 19) return '#eab308';
                    return '#e5e7eb';
                },
                resetAllPaths() {
                    const paths = $el.querySelectorAll('path[id]');
                    paths.forEach(path => {
                        const countryCode = path.id.toUpperCase();
                        const country = this.countryData[countryCode];
                        if (country) {
                            path.style.fill = this.getColor(country.rate);
                            path.style.stroke = '#fff';
                            path.style.strokeWidth = '0.5';
                        }
                    });
                },
                highlightCountry(country) {
                    this.resetAllPaths();
                    if (country) {
                        const path = $el.querySelector(`path#${country.iso_code.toLowerCase()}`);
                        if (path) {
                            path.style.fill = '#f97316';
                            path.style.stroke = '#ea580c';
                            path.style.strokeWidth = '1.5';
                        }
                    }
                }
            }"
                @mousemove="
                    const rect = $el.getBoundingClientRect();
                    mouseX = $event.clientX - rect.left;
                    mouseY = $event.clientY - rect.top;
                "
                x-init="
                    $nextTick(() => {
                        const paths = $el.querySelectorAll('path[id]');
                        paths.forEach(path => {
                            const countryCode = path.id.toUpperCase();
                            const country = countryData[countryCode];
                        
                            if (country) {
                                path.style.fill = getColor(country.rate);
                                path.style.stroke = '#fff';
                                path.style.strokeWidth = '0.5';
                                
                                if (country.active) {
                                    selectedCountry = country;
                                    path.style.fill = '#f97316';
                                    path.style.stroke = '#ea580c';
                                    path.style.strokeWidth = '1.5';
                                }
                        
                                path.addEventListener('mouseover', () => {
                                    if (!selectedCountry || selectedCountry.iso_code !== country.iso_code) {
                                        path.style.fill = '#fb923c';
                                        path.style.strokeWidth = '1';
                                        hoveredCountry = country;
                                    }
                                });
                        
                                path.addEventListener('mouseout', () => {
                                    if (!selectedCountry || selectedCountry.iso_code !== country.iso_code) {
                                        path.style.fill = getColor(country.rate);
                                        path.style.stroke = '#fff';
                                        path.style.strokeWidth = '0.5';
                                        hoveredCountry = null;
                                    }
                                });
                        
                                path.addEventListener('click', () => {
                                    selectedCountry = country;
                                    highlightCountry(country);
                                    hoveredCountry = null;
                                });
                            }
                        });
                    });"
>
    <h2 class="text-2xl font-bold mb-4">VAT Rates Map</h2>
    <div class="max-w-7xl mx-auto">
        <div class="{{ $layout === 'split' ? 'grid grid-cols-1 md:grid-cols-2 gap-6' : '' }}">
            <!-- Map Container -->
            <div class="eu-map-container relative">

                <!-- Legend -->
                <div class="absolute top-2 right-2 z-10 bg-white/95 px-3 py-2 rounded-lg shadow-md border backdrop-blur-sm">
                    <h3 class="text-xs font-semibold mb-1.5 text-gray-700">Standard VAT Rate</h3>
                    <div class="flex flex-wrap gap-x-3 gap-y-1">
                        <div class="flex items-center gap-1">
                            <div class="w-3 h-3 rounded-sm" style="background-color: #7c3aed"></div>
                            <span class="text-[10px] text-gray-600">≥25%</span>
                        </div>
                        <div class="flex items-center gap-1">
                            <div class="w-3 h-3 rounded-sm" style="background-color: #2563eb"></div>
                            <span class="text-[10px] text-gray-600">23-24%</span>
                        </div>
                        <div class="flex items-center gap-1">
                            <div class="w-3 h-3 rounded-sm" style="background-color: #0891b2"></div>
                            <span class="text-[10px] text-gray-600">21-22%</span>
                        </div>
                        <div class="flex items-center gap-1">
                            <div class="w-3 h-3 rounded-sm" style="background-color: #059669"></div>
                            <span class="text-[10px] text-gray-600">20%</span>
                        </div>
                        <div class="flex items-center gap-1">
                            <div class="w-3 h-3 rounded-sm" style="background-color: #65a30d"></div>
                            <span class="text-[10px] text-gray-600">19%</span>
                        </div>
                        <div class="flex items-center gap-1">
                            <div class="w-3 h-3 rounded-sm" style="background-color: #eab308"></div>
                            <span class="text-[10px] text-gray-600">&lt;19%</span>
                        </div>
                    </div>
                </div>

                <!-- SVG Map -->
                <div class="relative">
                    {!! file_get_contents(resource_path('images/europe.svg')) !!}
                </div>

                <!-- Tooltip - always show on hover -->
                <div x-show="hoveredCountry" x-cloak
                    class="absolute z-50 bg-white px-3 py-2 rounded-lg shadow-lg border pointer-events-none"
                    :style="{
                        left: Math.min(mouseX + 12, $el.offsetWidth - 200) + 'px',
                        top: (mouseY - 10) + 'px',
                        transform: 'translateY(-100%)'
                    }">
                    <template x-if="hoveredCountry">
                        <div class="flex items-center gap-2">
                            <img :src="'https://flagcdn.com/h20/' + hoveredCountry.iso_code.toLowerCase() + '.jpg'"
                                :alt="hoveredCountry.name + ' flag'" class="h-4 rounded border">
                            <span class="font-semibold text-sm" x-text="hoveredCountry.name"></span>
                            <span class="text-sm font-bold text-blue-600" x-text="hoveredCountry.rate + '%'"></span>
                        </div>
                    </template>
                </div>
            </div>

            <!-- Selected Country Details -->
            <div x-show="selectedCountry" x-cloak 
                class="{{ $layout === 'split' ? 'md:mt-0' : 'mt-4' }} bg-white p-5 rounded-xl shadow-lg border">
                <template x-if="selectedCountry">
                    <div>
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center gap-3">
                                <img :src="'https://flagcdn.com/h40/' + selectedCountry.iso_code.toLowerCase() + '.jpg'"
                                    :alt="selectedCountry.name + ' flag'" class="h-8 rounded border">
                                <h3 class="text-xl font-bold" x-text="selectedCountry.name"></h3>
                            </div>
                            <button @click="selectedCountry = null; resetAllPaths()" class="text-gray-400 hover:text-gray-600 transition-colors" title="Deselect">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            </button>
                        </div>
                        
                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <div class="bg-blue-50 rounded-lg p-3">
                                <div class="text-xs text-gray-500 font-medium">Standard Rate</div>
                                <div class="text-lg font-bold text-blue-700" x-text="selectedCountry.rate ? selectedCountry.rate + '%' : 'N/A'"></div>
                            </div>
                            <div class="bg-green-50 rounded-lg p-3">
                                <div class="text-xs text-gray-500 font-medium">Reduced Rate</div>
                                <div class="text-lg font-bold text-green-700" x-text="selectedCountry.reduced_rate ? selectedCountry.reduced_rate + '%' : 'N/A'"></div>
                            </div>
                        </div>

                        <div class="flex gap-2">
                            <a :href="'/country/' + selectedCountry.slug"
                                class="flex-1 text-center bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition text-sm font-medium">
                                Country Details
                            </a>
                            <a :href="'/vat-calculator/' + selectedCountry.slug"
                                class="flex-1 text-center bg-gray-800 text-white px-4 py-2 rounded-lg hover:bg-gray-900 transition text-sm font-medium">
                                VAT Calculator
                            </a>
                        </div>
                    </div>
                </template>
            </div>
        </div>

        <!-- Explore button - Only show for single layout -->
        <div x-show="'{{ $layout }}' === 'single' && !selectedCountry" class="text-center mt-3 mb-3">
            <a href="/vat-map" class="inline-flex items-center gap-2 bg-gray-800 text-white px-5 py-2.5 rounded-lg hover:bg-blue-600 transition text-sm font-medium">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"></path></svg>
                Explore Full VAT Map
            </a>
        </div>
    </div>

    <style>
        .eu-map-container svg {
            width: 100%;
            height: auto;
            max-width: 1000px;
            margin: 0 auto;
        }

        .eu-map-container path {
            transition: fill 0.2s ease, stroke-width 0.2s ease;
            cursor: pointer;
        }

        .eu-map-container path:hover {
            opacity: 0.9;
        }

        [x-cloak] {
            display: none !important;
        }
    </style>
</div>
