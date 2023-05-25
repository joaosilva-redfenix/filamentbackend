<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;

class DevicesFacilities extends Widget
{
    protected static ?int $sort = 3;

    protected int | string | array $columnSpan = 2;
    protected int | string | array $rowSpan = 2;

    public static function canView(): bool
{
    return true;
}
    protected static string $view = 'filament.widgets.devicefacilities';
}
