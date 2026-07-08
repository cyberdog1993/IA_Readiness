<?php

namespace App\Filament\Resources;

use App\Models\InternalEvaluation;
use Filament\Forms\Form;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Textarea;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class InternalEvaluationResource extends Resource
{
    protected static ?string $model = InternalEvaluation::class;
    protected static ?string $navigationGroup = 'Automatización';
    protected static ?string $navigationLabel = 'Evaluación interna';
    protected static ?string $modelLabel = 'evaluación interna';
    protected static ?string $pluralModelLabel = 'evaluaciones internas';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Select::make('process_id')->label('Proceso')->relationship('process', 'name'),
            TextInput::make('complexity')->label('Complejidad')->numeric(),
            TextInput::make('risk')->label('Riesgo')->numeric(),
            TextInput::make('impact')->label('Impacto')->numeric(),
            Toggle::make('requires_mcp')->label('Requiere MCP'),
            Toggle::make('requires_hermes_skill')->label('Requiere Skill Hermes'),
            Toggle::make('requires_n8n')->label('Requiere n8n'),
            Toggle::make('requires_ai')->label('Requiere IA'),
            Toggle::make('requires_ocr')->label('Requiere OCR'),
            TextInput::make('estimated_hours')->label('Horas estimadas')->numeric(),
            Textarea::make('technical_notes')->label('Observaciones técnicas')->columnSpanFull(),
        ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('process.name')->label('Proceso'),
            Tables\Columns\TextColumn::make('complexity')->label('Complejidad'),
            Tables\Columns\TextColumn::make('risk')->label('Riesgo'),
            Tables\Columns\TextColumn::make('impact')->label('Impacto'),
            Tables\Columns\TextColumn::make('estimated_hours')->label('Horas estimadas'),
        ])->actions([
            Tables\Actions\EditAction::make()->label('Editar'),
        ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => InternalEvaluationResource\Pages\ListInternalEvaluations::route('/'),
            'create' => InternalEvaluationResource\Pages\CreateInternalEvaluation::route('/create'),
            'edit' => InternalEvaluationResource\Pages\EditInternalEvaluation::route('/{record}/edit'),
        ];
    }
}
