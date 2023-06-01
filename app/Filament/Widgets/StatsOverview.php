<?php

namespace App\Filament\Widgets;

use App\Models\Device;
use App\Models\Group;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class StatsOverview extends BaseWidget
{
    protected static ?int $sort = 2;

    public static function canView(): bool
{   
    return auth()->user()->is_admin;
}
    
protected function getCards(): array
    {
        $userChartData = User::query()
            ->select([
                DB::raw('DATE(created_at) as date'),
                DB::raw('COUNT(*) as count')
            ])
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('count', 'date')
            ->toArray();

        $groupChartData = Group::query()
            ->select([
                DB::raw('DATE(created_at) as date'),
                DB::raw('COUNT(*) as count')
            ])
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('count', 'date')
            ->toArray();

        $deviceChartData = Device::query()
            ->select([
                DB::raw('DATE(created_at) as date'),
                DB::raw('COUNT(*) as count')
            ])
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('count', 'date')
            ->toArray();

        return [
            Card::make('Users', User::all()->count())
                ->chart($userChartData)
                ->color('success'),

            Card::make('Groups', Group::all()->count())
                ->chart($groupChartData)
                ->color('success'),

            Card::make('Devices', Device::all()->count())
                ->chart($deviceChartData)
                ->color('success'),
        ];
    }
}