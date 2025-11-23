<div class="bg-gradient-to-br from-blue-50 to-white p-6 rounded-xl shadow-xl mt-6 border border-blue-100 relative" x-data="{ open: true }">
    <div class="absolute top-6 right-6 cursor-pointer text-gray-400 hover:text-gray-600 transition-colors p-1" @click="open = !open">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 transition-transform duration-200" :class="{ 'rotate-180': !open }" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
        </svg>
    </div>

    <div class="flex items-center justify-between mb-6 pr-8 cursor-pointer" @click="open = !open">
        <h3 class="text-xl font-bold text-gray-900">📈 VAT Rate History</h3>
        @if($totalChanges > 0)
            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                {{ $totalChanges }} changes
            </span>
        @endif
    </div>

    <div x-show="open" x-collapse>
    <!-- Statistics Cards -->
    @if($earliestRate && $currentRate)
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
            <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-200">
                <div class="text-sm text-gray-600 mb-1">Rate in 2000</div>
                <div class="text-2xl font-bold text-gray-900">{{ number_format($earliestRate, 1) }}%</div>
            </div>
            <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-200">
                <div class="text-sm text-gray-600 mb-1">Current Rate</div>
                <div class="text-2xl font-bold text-gray-900">{{ number_format($currentRate, 1) }}%</div>
            </div>
            <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-200">
                <div class="text-sm text-gray-600 mb-1">Total Change</div>
                <div class="text-2xl font-bold {{ $rateChange > 0 ? 'text-red-600' : ($rateChange < 0 ? 'text-green-600' : 'text-gray-900') }}">
                    {{ $rateChange > 0 ? '+' : '' }}{{ number_format($rateChange, 1) }}%
                    @if($changePercentage !== null)
                        <span class="text-sm font-normal text-gray-500">
                            ({{ $changePercentage > 0 ? '+' : '' }}{{ number_format($changePercentage, 1) }}%)
                        </span>
                    @endif
                </div>
            </div>
        </div>

        <!-- Insight Badge -->
        @if(abs($rateChange) > 0)
            <div class="mb-4 p-3 {{ $rateChange > 0 ? 'bg-red-50 border-red-200' : 'bg-green-50 border-green-200' }} border rounded-lg">
                <div class="flex items-start gap-2">
                    <div class="mt-0.5">
                        @if($rateChange > 0)
                            <svg class="w-5 h-5 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                            </svg>
                        @else
                            <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M14.707 12.707a1 1 0 01-1.414 0L10 9.414l-3.293 3.293a1 1 0 01-1.414-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 010 1.414z" clip-rule="evenodd"></path>
                            </svg>
                        @endif
                    </div>
                    <div class="text-sm {{ $rateChange > 0 ? 'text-red-800' : 'text-green-800' }}">
                        <strong>{{ $country->name }}</strong> VAT rate has 
                        {{ $rateChange > 0 ? 'increased' : 'decreased' }} by 
                        <strong>{{ number_format(abs($rateChange), 1) }} percentage points</strong> 
                        since 2000
                    </div>
                </div>
            </div>
        @endif
    @endif

    <!-- Chart -->
    <div id="vatRateChart" style="min-height: 300px;" class="bg-white p-4 rounded-lg shadow-sm"></div>

    <!-- Legend & Info -->
    <div class="mt-4 p-4 bg-blue-50 rounded-lg border border-blue-100">
        <div class="flex items-start gap-2 text-sm text-blue-900">
            <svg class="w-5 h-5 text-blue-600 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
            </svg>
            <div>
                <strong>About this chart:</strong> This shows the evolution of the standard VAT rate for {{ $country->name }} 
                from 2000 onwards. Each step represents a rate change event. Data sourced from official EU tax databases.
            </div>
        </div>
    </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
        document.addEventListener('livewire:navigated', () => {
            initChart();
        });
        
        // Also init on first load
        document.addEventListener('DOMContentLoaded', () => {
             initChart();
        });

        function initChart() {
            const options = {
                series: @json($chartData),
                chart: {
                    type: 'area',
                    height: 350,
                    zoom: {
                        enabled: true
                    },
                    toolbar: {
                        show: true,
                        tools: {
                            download: true,
                            zoom: true,
                            pan: true,
                            reset: true
                        }
                    }
                },
                dataLabels: {
                    enabled: true,
                    style: {
                        fontSize: '12px',
                        colors: ['#fff']
                    },
                    background: {
                        enabled: true,
                        foreColor: '#3b82f6',
                        borderRadius: 2,
                        padding: 4,
                        opacity: 0.9
                    }
                },
                stroke: {
                    curve: 'stepline',
                    width: 3
                },
                fill: {
                    type: 'gradient',
                    gradient: {
                        shadeIntensity: 1,
                        opacityFrom: 0.7,
                        opacityTo: 0.3,
                        stops: [0, 90, 100]
                    }
                },
                title: {
                    text: 'Standard VAT Rate Evolution (2000-Present)',
                    align: 'left',
                    style: {
                        fontSize: '16px',
                        fontWeight: 'bold',
                        color: '#1f2937'
                    }
                },
                xaxis: {
                    type: 'datetime',
                    labels: {
                        format: 'yyyy'
                    }
                },
                yaxis: {
                    min: 0,
                    max: 30,
                    opposite: false,
                    title: {
                        text: 'Rate (%)',
                        style: {
                            fontSize: '14px',
                            fontWeight: 600,
                            color: '#6b7280'
                        }
                    },
                    labels: {
                        formatter: function(value) {
                            return value.toFixed(1) + '%';
                        }
                    }
                },
                legend: {
                    show: false
                },
                colors: ['#3b82f6'],
                grid: {
                    borderColor: '#e5e7eb',
                    strokeDashArray: 4
                },
                tooltip: {
                    x: {
                        format: 'dd MMM yyyy'
                    },
                    y: {
                        formatter: function(value) {
                            return value.toFixed(1) + '%';
                        }
                    }
                }
            };

            const chartElement = document.querySelector("#vatRateChart");
            if (chartElement) {
                chartElement.innerHTML = ''; // Clear previous chart if any
                const chart = new ApexCharts(chartElement, options);
                chart.render();
            }
        }
    </script>
</div>
