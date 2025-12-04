<div class="bg-gradient-to-br from-blue-50 to-white p-5 rounded-xl shadow-xl mt-6 border border-blue-100 relative" x-data="{ open: true }">
    <div class="absolute top-5 right-5 cursor-pointer text-gray-400 hover:text-gray-600 transition-colors p-1" @click="open = !open">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 transition-transform duration-200" :class="{ 'rotate-180': !open }" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
        </svg>
    </div>

    <div class="flex items-center justify-between mb-5 pr-8 cursor-pointer" @click="open = !open">
        <h3 class="text-lg font-bold text-gray-900">📈 VAT Rate History</h3>
        <?php if($totalChanges > 0): ?>
            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                <?php echo e($totalChanges); ?> changes
            </span>
        <?php endif; ?>
    </div>

    <div x-show="open" x-collapse>
    <!-- Statistics Cards -->
    <?php if($earliestRate && $currentRate): ?>
        <div class="grid grid-cols-2 sm:grid-cols-3 gap-3 mb-5">
            <div class="bg-white p-3 rounded-lg shadow-sm border border-gray-200">
                <div class="text-xs text-gray-600 mb-1">Rate in 2000</div>
                <div class="text-xl font-bold text-gray-900"><?php echo e(number_format($earliestRate, 1)); ?>%</div>
            </div>
            <div class="bg-white p-3 rounded-lg shadow-sm border border-gray-200">
                <div class="text-xs text-gray-600 mb-1">Current Rate</div>
                <div class="text-xl font-bold text-gray-900"><?php echo e(number_format($currentRate, 1)); ?>%</div>
            </div>
            <div class="bg-white p-3 rounded-lg shadow-sm border border-gray-200 col-span-2 sm:col-span-1">
                <div class="text-xs text-gray-600 mb-1">Total Change</div>
                <div class="text-xl font-bold <?php echo e($rateChange > 0 ? 'text-red-600' : ($rateChange < 0 ? 'text-green-600' : 'text-gray-900')); ?>">
                    <?php echo e($rateChange > 0 ? '+' : ''); ?><?php echo e(number_format($rateChange, 1)); ?>%
                    <?php if($changePercentage !== null): ?>
                        <span class="text-xs font-normal text-gray-500">
                            (<?php echo e($changePercentage > 0 ? '+' : ''); ?><?php echo e(number_format($changePercentage, 1)); ?>%)
                        </span>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Insight Badge -->
        <?php if(abs($rateChange) > 0): ?>
            <div class="mb-4 p-3 <?php echo e($rateChange > 0 ? 'bg-red-50 border-red-200' : 'bg-green-50 border-green-200'); ?> border rounded-lg">
                <div class="flex items-start gap-2">
                    <div class="mt-0.5">
                        <?php if($rateChange > 0): ?>
                            <svg class="w-4 h-4 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                            </svg>
                        <?php else: ?>
                            <svg class="w-4 h-4 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M14.707 12.707a1 1 0 01-1.414 0L10 9.414l-3.293 3.293a1 1 0 01-1.414-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 010 1.414z" clip-rule="evenodd"></path>
                            </svg>
                        <?php endif; ?>
                    </div>
                    <div class="text-sm <?php echo e($rateChange > 0 ? 'text-red-800' : 'text-green-800'); ?>">
                        <strong><?php echo e($country->name); ?></strong> VAT rate has 
                        <?php echo e($rateChange > 0 ? 'increased' : 'decreased'); ?> by 
                        <strong><?php echo e(number_format(abs($rateChange), 1)); ?> percentage points</strong> 
                        since 2000
                    </div>
                </div>
            </div>
        <?php endif; ?>
    <?php endif; ?>

    <!-- Chart -->
    <div id="vatRateChart" style="min-height: 250px;" class="bg-white p-3 rounded-lg shadow-sm"></div>

    <!-- Legend & Info -->
    <div class="mt-4 p-3 bg-blue-50 rounded-lg border border-blue-100">
        <div class="flex items-start gap-2 text-xs text-blue-900">
            <svg class="w-4 h-4 text-blue-600 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
            </svg>
            <div>
                <strong>About this chart:</strong> This shows the evolution of the standard VAT rate for <?php echo e($country->name); ?> 
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
                series: <?php echo json_encode($chartData, 15, 512) ?>,
                chart: {
                    type: 'area',
                    height: 300,
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
                        fontSize: '10px',
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
                    width: 2
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
                        fontSize: '14px',
                        fontWeight: 'bold',
                        color: '#1f2937'
                    }
                },
                xaxis: {
                    type: 'datetime',
                    labels: {
                        format: 'yyyy',
                        style: {
                            fontSize: '10px'
                        }
                    }
                },
                yaxis: {
                    min: 0,
                    max: 30,
                    opposite: false,
                    title: {
                        text: 'Rate (%)',
                        style: {
                            fontSize: '12px',
                            fontWeight: 600,
                            color: '#6b7280'
                        }
                    },
                    labels: {
                        style: {
                            fontSize: '10px'
                        },
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
</div><?php /**PATH /home/runner/work/eu-vat.info/eu-vat.info/resources/views/livewire/vat-rate-history-chart.blade.php ENDPATH**/ ?>