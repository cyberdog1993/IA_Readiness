<?php

namespace App\Filament\Resources\ProcessResource\Pages;

use App\Filament\Resources\ClientResource;
use App\Filament\Resources\ProcessResource;
use Filament\Actions\Action;
use Filament\Resources\Pages\EditRecord;

class EditProcess extends EditRecord
{
    protected static string $resource = ProcessResource::class;

    protected function getHeaderActions(): array
    {
        $actions = [
            Action::make('pdf')
                ->label('PDF')
                ->url(route('consulting-intake.pdf', $this->record))
                ->button()
                ->openUrlInNewTab(),
            Action::make('markdown')
                ->label('Markdown')
                ->url(route('consulting-intake.markdown', $this->record))
                ->button()
                ->openUrlInNewTab(),
            Action::make('json')
                ->label('JSON')
                ->url(route('consulting-intake.json', $this->record))
                ->button()
                ->openUrlInNewTab(),
        ];

        if ($this->record->client) {
            $actions[] = Action::make('ver_cliente')
                ->label('Ir al cliente')
                ->url(ClientResource::getUrl('edit', ['record' => $this->record->client]))
                ->icon('heroicon-o-user')
                ->button()
                ->openUrlInNewTab();
        }

        return $actions;
    }
}
