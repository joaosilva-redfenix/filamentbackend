<?php

namespace App\Filament\Resources\DeviceResource\Pages;

use App\Filament\Resources\DeviceResource;
use Filament\Facades\Filament;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateDevice extends CreateRecord
{
    protected static string $resource = DeviceResource::class;

    // gets rid of the create & create another button
    protected static bool $canCreateAnother = false;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['group_id'] = Filament::auth()->user()->group_id;
     
        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

}