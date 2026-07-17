<?php

namespace App\Filament\Resources\LeadResource\Pages;

use App\Filament\Resources\LeadResource;
use Filament\Actions\Action;
use Filament\Resources\Pages\EditRecord;

class EditLead extends EditRecord
{
    protected static string $resource = LeadResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('pdf_cliente')
                ->label('PDF cliente')
                ->url(route('exports.client-pdf', $this->record))
                ->button()
                ->openUrlInNewTab(),
            Action::make('markdown')
                ->label('Markdown')
                ->url(route('exports.markdown', $this->record))
                ->button()
                ->openUrlInNewTab(),
            Action::make('json')
                ->label('JSON')
                ->url(route('exports.json', $this->record))
                ->button()
                ->openUrlInNewTab(),
            Action::make('excel')
                ->label('Excel')
                ->url(route('exports.excel', $this->record))
                ->button()
                ->openUrlInNewTab(),
            Action::make('word')
                ->label('Word')
                ->url(route('exports.word', $this->record))
                ->button()
                ->openUrlInNewTab(),
            Action::make('payload')
                ->label('Payload IA / n8n')
                ->url(route('exports.payload', $this->record))
                ->button()
                ->openUrlInNewTab(),
            Action::make('pdf_interno')
                ->label('PDF interno')
                ->url(route('exports.internal-pdf', $this->record))
                ->button()
                ->openUrlInNewTab(),
        ];
    }
}
