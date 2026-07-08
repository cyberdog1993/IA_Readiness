<?php

namespace App\Filament\Resources\DocumentEvidenceResource\Pages;

use App\Filament\Resources\DocumentEvidenceResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListDocumentEvidences extends ListRecords
{
    protected static string $resource = DocumentEvidenceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()->label('Nuevo documento'),
        ];
    }
}
