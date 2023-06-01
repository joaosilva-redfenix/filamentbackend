<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;

class adminDevices extends Widget
{
    protected static ?int $sort = 5;
    protected int | string | array $columnSpan = 2;
    protected static string $view = 'filament.widgets.admin-devices';

    public static function canView(): bool
{   
    return auth()->user()->is_admin;
}
}