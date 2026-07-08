<?php

namespace App\Filament\Resources\CurrentProblemResource\Pages;

use App\Filament\Resources\CurrentProblemResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListCurrentProblems extends ListRecords
{
    protected static string $resource = CurrentProblemResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()->label('Nuevo problema'),
        ];
    }
}
