<?php

namespace App\Filament\Resources\ClientResource\Pages;

use App\Filament\Resources\ClientResource;
use Filament\Actions\Action;
use Filament\Resources\Pages\EditRecord;

class EditClient extends EditRecord
{
    protected static string $resource = ClientResource::class;

    protected function getHeaderActions(): array
    {
        $actions = [];

        if ($this->record->lead) {
            $actions[] = Action::make('diagnosis_pdf')
                ->label('PDF diagnóstico')
                ->url(route('exports.client-pdf', $this->record->lead))
                ->button()
                ->openUrlInNewTab();

            $actions[] = Action::make('markdown')
                ->label('Markdown')
                ->url(route('exports.markdown', $this->record->lead))
                ->button()
                ->openUrlInNewTab();

            $actions[] = Action::make('json')
                ->label('JSON')
                ->url(route('exports.json', $this->record->lead))
                ->button()
                ->openUrlInNewTab();

            $actions[] = Action::make('excel')
                ->label('Excel')
                ->url(route('exports.excel', $this->record->lead))
                ->button()
                ->openUrlInNewTab();

            $actions[] = Action::make('word')
                ->label('Word')
                ->url(route('exports.word', $this->record->lead))
                ->button()
                ->openUrlInNewTab();

            $actions[] = Action::make('payload')
                ->label('Payload IA / n8n')
                ->url(route('exports.payload', $this->record->lead))
                ->button()
                ->openUrlInNewTab();
        }

        $process = $this->record->processes()->latest()->first();

        if ($process) {
            $actions[] = Action::make('process_pdf')
                ->label('PDF proceso')
                ->url(route('consulting-intake.pdf', $process))
                ->button()
                ->openUrlInNewTab();

            $actions[] = Action::make('process_markdown')
                ->label('Markdown proceso')
                ->url(route('consulting-intake.markdown', $process))
                ->button()
                ->openUrlInNewTab();

            $actions[] = Action::make('process_json')
                ->label('JSON proceso')
                ->url(route('consulting-intake.json', $process))
                ->button()
                ->openUrlInNewTab();
        }

        return $actions;
    }
}
