<x-filament::widget>
    <x-filament::card>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <?php
        // Step 1: Retrieve devices based on the user's group_id
        $devices = DB::table('devices')
            ->where('group_id', auth()->user()->group_id)
            ->get();
        
        // Step 2: Group devices by facility_id and count the number of devices
        $deviceCounts = $devices->groupBy('facility_id')->map->count();
        
        // Step 3: Join facilities table to retrieve facility names
        $deviceCounts = $deviceCounts->mapWithKeys(function ($count, $facilityId) {
            $facilityName = DB::table('facilities')
                ->where('id', $facilityId)
                ->value('name');
        
            return [$facilityName => $count];
        });
        ?>
        
        <!-- Step 4: Render the pie chart -->
        <div>
            <canvas id="devicesChart"></canvas>
        </div>
        
        <script>
            var ctx = document.getElementById('devicesChart').getContext('2d');
            var devicesChart = new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: {!! json_encode($deviceCounts->keys()) !!},
                    datasets: [{
                        data: {!! json_encode($deviceCounts->values()) !!},
                        backgroundColor: [
                            '#FF6384',
                            '#36A2EB',
                            '#FFCE56',
                            // Add more colors if needed
                        ]
                    }]
                },
                options: {
                    // Customize chart options as per your requirements
                }
            });
        </script>
        
    </x-filament::card>
</x-filament::widget>
