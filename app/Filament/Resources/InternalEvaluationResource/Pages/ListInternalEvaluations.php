<?php

namespace App\Filament\Resources\InternalEvaluationResource\Pages;

use App\Filament\Resources\InternalEvaluationResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListInternalEvaluations extends ListRecords
{
    protected static string $resource = InternalEvaluationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()->label('Nueva evaluación'),
        ];
    }
}
