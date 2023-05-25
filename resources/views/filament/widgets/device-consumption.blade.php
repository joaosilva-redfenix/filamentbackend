<x-filament::widget>
    <x-filament::card>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <?php
        // Step 1: Retrieve devices based on the user's group_id
        $devices = DB::table('devices')
            ->where('group_id', auth()->user()->group_id)
            ->get();
        
        // Step 2: Group devices by consumption and count the number of devices
        $deviceCounts = $devices->groupBy('consumption')->map->count();
        
        // Step 3: Prepare data for the column chart
        $consumptions = $deviceCounts->keys()->map(function ($consumption) {
            return "Consumption " . $consumption;
        });
        $counts = $deviceCounts->values();
        ?>
        
        <!-- Step 4: Render the column chart -->
        <div>
            <canvas id="devicesChart2"></canvas>
        </div>
        
        <script>
            var ctx = document.getElementById('devicesChart2').getContext('2d');
            var devicesChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: {!! json_encode($consumptions) !!},
                    datasets: [{
                        label: 'Devices',
                        data: {!! json_encode($counts) !!},
                        backgroundColor: 'rgba(54, 162, 235, 0.5)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true,
                            precision: 0,
                            stepSize: 1
                        }
                    }
                }
            });
        </script>
    </x-filament::card>
</x-filament::widget>