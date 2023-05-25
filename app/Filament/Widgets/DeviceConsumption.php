<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;

class DeviceConsumption extends Widget
{
    protected static ?int $sort = 2;

    protected int | string | array $columnSpan = 2;

    public static function canView(): bool
{
    $user = auth()->user();
    return $user && $user->group_id !== null;
}

    protected static string $view = 'filament.widgets.device-consumption';
}
