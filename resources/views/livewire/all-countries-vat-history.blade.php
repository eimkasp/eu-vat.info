<div class="bg-white p-6 rounded-xl shadow-xl border border-gray-100">
    <div class="mb-6">
        <h3 class="text-xl font-bold text-gray-900">🌍 EU VAT Rates History (2000-{{ date('Y') }})</h3>
        <p class="text-sm text-gray-500 mt-1">Evolution of standard VAT rates across all EU countries over time.</p>
    </div>

    <div id="vatHistoryChart" style="min-height: 600px;"></div>

    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
        document.addEventListener('livewire:navigated', () => {
            initHistoryChart();
        });
        
        document.addEventListener('DOMContentLoaded', () => {
             initHistoryChart();
        });

        function initHistoryChart() {
            const options = {
                series: @json($chartData),
                chart: {
                    height: 600,
                    type: 'line',
                    zoom: {
                        enabled: true
                    },
                    toolbar: {
                        show: true
                    }
                },
                stroke: {
                    width: 2,
                    curve: 'monotoneCubic'
                },
                dataLabels: {
                    enabled: false
                },
                title: {
                    text: 'VAT Standard Rate Evolution',
                    align: 'left'
                },
                grid: {
                    borderColor: '#e7e7e7',
                    row: {
                        colors: ['#f3f3f3', 'transparent'],
                        opacity: 0.5
                    },
                },
                xaxis: {
                    type: 'category',
                    title: {
                        text: 'Year'
                    }
                },
                yaxis: {
                    title: {
                        text: 'Rate (%)'
                    },
                    min: 0,
                    max: 30
                },
                legend: {
                    position: 'top',
                    horizontalAlign: 'right',
                    floating: true,
                    offsetY: -25,
                    offsetX: -5
                },
                tooltip: {
                    y: {
                        formatter: function(val) {
                            return val + "%";
                        }
                    }
                }
            };

            const chartElement = document.querySelector("#vatHistoryChart");
            if (chartElement) {
                chartElement.innerHTML = '';
                const chart = new ApexCharts(chartElement, options);
                chart.render();
            }
        }
    </script>
</div>
