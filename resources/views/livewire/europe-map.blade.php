<div class="relative">
    <h2 class="text-2xl font-bold mb-6">VAT Rates Map</h2>
    <div class="max-w-7xl mx-auto">
        <div class="{{ $layout === 'split' ? 'grid grid-cols-1 md:grid-cols-2 gap-6' : '' }}">
            <!-- Map Container -->
            <div class="eu-map-container relative" x-data="{
                hoveredCountry: null,
                selectedCountry: @if($activeCountry) {{ json_encode($countryData[strtoupper($activeCountry->iso_code)] ?? null) }} @else null @endif,
                mouseX: 0,
                mouseY: 0,
                countryData: @entangle('countryData'),
                getColor(rate) {
                    if (!rate) return '#ececec';
                    // Using predefined rate ranges for more distinct green shades
                    if (rate >= 25) return 'rgb(0, 100, 0)';      // Dark green
                    if (rate >= 22) return 'rgb(34, 139, 34)';    // Forest green
                    if (rate >= 21) return 'rgb(60, 179, 113)';   // Medium sea green
                    if (rate >= 20) return 'rgb(46, 139, 87)';    // Sea green
                    if (rate >= 19) return 'rgb(144, 238, 144)';  // Light green
                    if (rate < 19) return 'rgb(152, 251, 152)';   // Pale green
                    return '#ececec'; // Default color for no data
                }
            }"
                @mousemove="
                    const rect = $el.getBoundingClientRect();
                    mouseX = $event.clientX - rect.left;
                    mouseY = $event.clientY - rect.top;
                "
                x-init="const paths = $el.querySelectorAll('path[id]');
                paths.forEach(path => {
                    const countryCode = path.id.toUpperCase();
                    const country = countryData[countryCode];
                
                    if (country) {
                        // Set initial color based on active state or rate
                        if (country.active) {
                            path.style.fill = '#3b82f6';
                            selectedCountry = country;
                        } else {
                            path.style.fill = getColor(country.rate);
                        }
                
                        path.addEventListener('mouseover', () => {
                            if (!selectedCountry) {
                                path.style.fill = '#3b82f6';
                                hoveredCountry = country;
                            }
                        });
                
                        path.addEventListener('mouseout', () => {
                            if (!selectedCountry) {
                                path.style.fill = getColor(country.rate);
                                hoveredCountry = null;
                            }
                        });
                
                        path.addEventListener('click', () => {
                            selectedCountry = country;
                            hoveredCountry = null;
                        });
                    }
                });">

                <!-- Add Legend on top of the map -->
                <div class="absolute top-0 right-0 z-10 bg-white/90 p-2 rounded-lg shadow-sm border backdrop-blur-sm">
                    <h3 class="text-xs font-medium mb-1">VAT Rates</h3>
                    <div class="grid grid-cols-3 gap-1">
                        <div class="flex items-center gap-1">
                            <div class="w-3 h-3 rounded-sm" style="background-color: rgb(0, 100, 0)"></div>
                            <span class="text-[10px]">≥25%</span>
                        </div>
                        <div class="flex items-center gap-1">
                            <div class="w-3 h-3 rounded-sm" style="background-color: rgb(34, 139, 34)"></div>
                            <span class="text-[10px]">23-24%</span>
                        </div>
                        <div class="flex items-center gap-1">
                            <div class="w-3 h-3 rounded-sm" style="background-color: rgb(60, 179, 113)"></div>
                            <span class="text-[10px]">21-22%</span>
                        </div>
                        <div class="flex items-center gap-1">
                            <div class="w-3 h-3 rounded-sm" style="background-color: rgb(46, 139, 87)"></div>
                            <span class="text-[10px]">20%</span>
                        </div>
                        <div class="flex items-center gap-1">
                            <div class="w-3 h-3 rounded-sm" style="background-color: rgb(144, 238, 144)"></div>
                            <span class="text-[10px]">19%</span>
                        </div>
                        <div class="flex items-center gap-1">
                            <div class="w-3 h-3 rounded-sm" style="background-color: rgb(152, 251, 152)"></div>
                            <span class="text-[10px]"><19%</span>
                        </div>
                    </div>
                </div>

                <!-- SVG Map -->
                <div class="relative {{ $layout === 'single' ? 'ml-[-80px]' : '' }}">
                    {!! file_get_contents(resource_path('images/europe.svg')) !!}
                </div>

                <!-- Tooltip -->
                <div x-show="hoveredCountry && !selectedCountry" x-cloak
                    class="absolute z-50 bg-white p-3 rounded-lg shadow-lg border"
                    :style="{
                        left: (mouseX + 10) + 'px',
                        top: (mouseY - 10) + 'px',
                        transform: 'translateY(-100%)'
                    }">
                    <div class="flex items-center gap-2">
                        <!-- Add null check for hoveredCountry -->
                        <template x-if="hoveredCountry">
                            <img :src="'https://flagcdn.com/h20/' + hoveredCountry.iso_code.toLowerCase() + '.jpg'"
                                :alt="hoveredCountry.name + ' flag'" class="h-4 rounded border">
                        </template>
                        <div class="font-semibold" x-text="hoveredCountry ? hoveredCountry.name : ''"></div>
                    </div>
                    <div>
                        <!-- Add null checks for hoveredCountry properties -->
                        <div x-show="hoveredCountry && hoveredCountry.rate">
                            Standard VAT: <span x-text="hoveredCountry.rate + '%'"></span>
                        </div>
                        <div x-show="hoveredCountry && hoveredCountry.reduced_rate">
                            Reduced VAT: <span x-text="hoveredCountry.reduced_rate + '%'"></span>
                        </div>
                    </div>

                </div>

                <!-- Remove the old legend -->
                {{-- Remove or comment out the old legend div that was after the map --}}

            </div>

            <!-- Selected Country Details - Show inline for split layout -->
            <div x-show="selectedCountry" x-cloak 
                class="{{ $layout === 'split' ? 'md:mt-0' : 'mt-6' }} bg-white p-6 rounded-lg shadow-lg border">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center gap-3">
                        <img :src="'https://flagcdn.com/h40/' + selectedCountry?.iso_code.toLowerCase() + '.jpg'"
                            :alt="selectedCountry?.name + ' flag'" class="h-8 rounded border">
                        <h3 class="text-xl font-bold" x-text="selectedCountry?.name"></h3>
                    </div>
                </div>
                
                <!-- Enhanced country details for split layout -->
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <div class="text-sm text-gray-600">Standard Rate</div>
                        <div class="font-semibold" x-text="selectedCountry?.rate + '%'"></div>
                    </div>
                    <div>
                        <div class="text-sm text-gray-600">Reduced Rate</div>
                        <div class="font-semibold"
                            x-text="selectedCountry?.reduced_rate ? selectedCountry?.reduced_rate + '%' : 'N/A'"></div>
                    </div>
                </div>

                <!-- Additional details for split layout -->
                <template x-if="'{{ $layout }}' === 'split'">
                    <div class="mt-4 pt-4 border-t">
                        <h4 class="font-medium mb-2">VAT Information</h4>
                        <p class="text-sm text-gray-600">
                            Click the button below to access detailed VAT information, rates, and calculation tools for this country.
                        </p>
                    </div>
                </template>

                <div class="mt-4">
                    <a :href="'/vat-calculator/' + selectedCountry?.slug"
                        class="inline-block bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition">
                        Open VAT Calculator
                    </a>
                </div>
            </div>
        </div>

        <!-- Explore button - Only show for single layout -->
        <div x-show="'{{ $layout }}' === 'single'" class="text-center mt-3">
            <a href="/vat-map" class="inline-block bg-gray-800 text-white px-4 py-2 rounded hover:bg-blue-600 transition">
                Explore VAT Map 🗺️
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
            transition: all 0.3s;
            cursor: pointer;
        }

        .eu-map-container path:hover {
            opacity: 0.8;
            fill: #3b82f6; // Keep blue for hover state
            transform: translateY(-2px);
        }

        [x-cloak] {
            display: none !important;
        }
    </style>
</div>
