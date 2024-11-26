<div class="relative">
    <h2 class="text-2xl font-bold mb-6">VAT Rates Map</h2>
    <div class="max-w-7xl mx-auto">
        <div class="eu-map-container relative" x-data="{
            hoveredCountry: null,
            selectedCountry: null,
            mouseX: 0,
            mouseY: 0,
            countryData: @entangle('countryData'),
            getColor(rate) {
                if (!rate) return '#ececec';
                const minRate = {{ $minRate }};
                const maxRate = {{ $maxRate }};
                const percentage = (rate - minRate) / (maxRate - minRate);
                const red = Math.floor(percentage * 255);
                const green = Math.floor(255 - (percentage * 128));
                const blue = Math.floor(50);
                return `rgb(${red}, ${green}, ${blue})`;
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
                    path.style.fill = getColor(country.rate);
            
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

            <!-- SVG Map -->
            <div class="relative ml-[-80px]">
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

            <!-- Selected Country Details -->
            <div x-show="selectedCountry" x-cloak class="mt-6 bg-white p-6 rounded-lg shadow-lg border">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center gap-3">
                        <img :src="'https://flagcdn.com/h40/' + selectedCountry?.iso_code.toLowerCase() + '.jpg'"
                            :alt="selectedCountry?.name + ' flag'" class="h-8 rounded border">
                        <h3 class="text-xl font-bold" x-text="selectedCountry?.name"></h3>
                    </div>

                </div>
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
                <div class="mt-4">
                    <a :href="'/vat-calculator/' + selectedCountry?.slug"
                        class="inline-block bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition">
                        Open VAT Calculator
                    </a>
                </div>
            </div>
        </div>
    <div class="text-center mt-3">
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
            fill: #003399;
            transform: translateY(-2px);
        }

        [x-cloak] {
            display: none !important;
        }
    </style>
</div>
