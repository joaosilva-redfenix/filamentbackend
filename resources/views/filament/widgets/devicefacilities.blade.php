<x-filament::widget>
    <x-filament::card>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        
        <?php
        $devices = DB::table('devices')
            ->where('group_id', auth()->user()->group_id)
            ->get();
        
        $deviceCounts = $devices->groupBy('facility_id')->map->count();
        
        $deviceCounts = $deviceCounts->mapWithKeys(function ($count, $facilityId) {
            $facilityName = DB::table('facilities')
                ->where('id', $facilityId)
                ->value('name');
        
            return [$facilityName => $count];
        });
        ?>
        
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
                            '#003f5c',
                            '#2f4b7c',
                            '#665191',
                            '#a05195',
                            '#d45087',
                            '#f95d6a',
                            '#ff7c43',
                            '#ffa600',
                            '#ffdc00',
                            '#a2c8ab',
                        ]
                    }]
                },
                options: {
  
                }
            });
        </script>
    </x-filament::card>
</x-filament::widget>
