<?php
 
namespace App\Filament\Pages;
 
use Filament\Pages\Dashboard as BasePage;
 
class Dashboard extends BasePage
{
    protected function getColumns(): int | array
{
    return 4;
}

protected function getRows(): int | array
{
    return 3;
}

}