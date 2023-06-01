<x-filament::widget>
    <x-filament::card>
        <div>
            <canvas id="deviceChart3"></canvas>
        </div>
        
        <?php
            $deviceChartData = DB::table('devices')
                ->select([
                    DB::raw('DATE_FORMAT(created_at, "%Y-%m-%d") as date'),
                    DB::raw('DATE_FORMAT(created_at, "%M %Y") as month_year'),
                    DB::raw('COUNT(*) as count')
                ])
                ->groupBy('date', 'month_year')
                ->orderBy('date')
                ->pluck('count', 'date')
                ->toArray();
        ?>
        
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            var deviceData = @json($deviceChartData);
        
            var dates = Object.keys(deviceData);
            var counts = Object.values(deviceData);
        
            var ctx = document.getElementById('deviceChart3').getContext('2d');
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: dates,
                    datasets: [{
                        label: 'Devices Created',
                        data: counts,
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderColor: 'rgba(0, 128, 0, 1)',
                        borderWidth: 2
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        x: {
                            display: true,
                            title: {
                                display: true,
                                text: 'Date'
                            }
                        },
                        y: {
                            display: true,
                            title: {
                                display: true,
                                text: 'Number of Devices'
                            },
                            ticks: {
                                beginAtZero: true
                            }
                        }
                    }
                }
            });
        </script>
        
    </x-filament::card>
</x-filament::widget>

