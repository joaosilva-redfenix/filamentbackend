<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;

class adminDevices extends Widget
{
    protected static ?int $sort = 5;
    protected int | string | array $columnSpan = 3;
    protected static string $view = 'filament.widgets.admin-devices';

    public static function canView(): bool
{   
    return auth()->user()->is_admin;
}
}