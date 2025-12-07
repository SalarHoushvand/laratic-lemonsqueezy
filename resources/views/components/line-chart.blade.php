@props([
    'data',
    'categories',
    'height' => '250',
    'toolbar' => false,
    'dataLabels' => false,
    'currency' => null,
    'id' => 'chart-' . uniqid(),
    'color' => 'primary',
])

<style>
    .apexcharts-title-text {
        font-family: var(--font-sans) !important;
        font-weight: bold;
        display: none;
    }

    .apexcharts-text {
        font-family: var(--font-title) !important;
    }

    .apexcharts-yaxis-label {
        fill: var(--color-on-surface);
    }

    .apexcharts-xaxis-label {
        fill: var(--color-on-surface);
    }

    .apexcharts-tooltip {
        background-color: var(--color-surface);
        color: var(--color-on-surface);
        border-color: var(--color-outline);
    }

    .apexcharts-tooltip .apexcharts-tooltip-title {
        color: var(--color-on-surface);
        background-color: var(--color-surface-alt);
    }

    .apexcharts-tooltip .apexcharts-tooltip-marker {
        background-color: var(--color-{{ $color }});
    }

    .apexcharts-line {
        stroke: var(--color-{{ $color }});
    }

    .apexcharts-gridline {
        opacity: 0.2;
    }

    .apexcharts-marker {
        fill: var(--color-{{ $color }});
        stroke: var(--color-outline-strong);
    }

    .dark .apexcharts-yaxis-label {
        fill: var(--color-on-surface-dark);
    }

    .dark .apexcharts-xaxis-label {
        fill: var(--color-on-surface-dark);
    }

    .dark .apexcharts-tooltip {
        background-color: var(--color-surface-dark);
        color: var(--color-on-surface-dark);
        border-color: var(--color-outline-dark);
    }

    .dark .apexcharts-tooltip .apexcharts-tooltip-title {
        color: var(--color-on-surface-dark);
        background-color: var(--color-surfaceDarkAlt);
    }

    .dark .apexcharts-tooltip-marker {
        background-color: var(--color-{{ $color }}-dark) !important;
    }

    .dark .apexcharts-line {
        stroke: var(--color-{{ $color }}-dark);
    }
</style>

<div class="w-full" id="{{ $id }}"></div>


@push('scripts')
    @vite(['resources/js/charts.js'])
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            var data = @json($data);
            var categories = @json($categories);
            var currency = @json($currency);

            var options = {
                series: [{
                    data: data
                }],
                chart: {
                    height: @json($height),
                    type: 'line',
                    zoom: {
                        enabled: false
                    },
                    toolbar: {
                        show: @json($toolbar)
                    },
                },
                dataLabels: {
                    enabled: @json($dataLabels)
                },
                stroke: {
                    curve: 'smooth'
                },
                grid: {
                    row: {
                        colors: ['transparent', 'transparent'],
                        opacity: 0.1
                    },
                },
                yaxis: {
                    labels: {
                        formatter: function(value) {
                            if (!currency) {
                                return value;
                            }
                            
                            if (value >= 1000) {
                                return currency + (value / 1000).toFixed(1) + "K";
                            }
                            return currency + value;
                        }
                    },
                },
                xaxis: {
                    categories: categories
                },
                tooltip: {
                    custom: function({ series, seriesIndex, dataPointIndex, w }) {
                        const value = series[seriesIndex][dataPointIndex];
                        return '<div class="p-2">' +
                            '<span>' + (currency ? currency : '') + value + '</span>' +
                            '</div>';
                    }
                }
            };

            var chart = new ApexCharts(document.querySelector("#{{ $id }}"), options);
            chart.render();
        }, {
            once: true
        });
    </script>
@endpush
