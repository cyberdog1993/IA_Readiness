<?php

namespace App\Filament\Resources\AutomationOpportunityResource\Pages;

use App\Filament\Resources\AutomationOpportunityResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListAutomationOpportunities extends ListRecords
{
    protected static string $resource = AutomationOpportunityResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()->label('Nueva oportunidad'),
        ];
    }
}
