<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;

class DeviceConsumption extends Widget
{
    protected static ?int $sort = 2;

    protected int | string | array $columnSpan = 2;

    protected static string $view = 'filament.widgets.device-consumption';
}
