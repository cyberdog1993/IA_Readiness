<?php

namespace App\Filament\Resources\SystemIntegrationResource\Pages;

use App\Filament\Resources\SystemIntegrationResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListSystemIntegrations extends ListRecords
{
    protected static string $resource = SystemIntegrationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()->label('Nuevo sistema'),
        ];
    }
}
