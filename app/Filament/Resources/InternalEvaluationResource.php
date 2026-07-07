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

    public static function form(Form $form): Form
    {
        return $form->schema([
            Select::make('process_id')->relationship('process', 'name'),
            TextInput::make('complexity')->numeric(),
            TextInput::make('risk')->numeric(),
            TextInput::make('impact')->numeric(),
            Toggle::make('requires_mcp'),
            Toggle::make('requires_hermes_skill'),
            Toggle::make('requires_n8n'),
            Toggle::make('requires_ai'),
            Toggle::make('requires_ocr'),
            TextInput::make('estimated_hours')->numeric(),
            Textarea::make('technical_notes')->columnSpanFull(),
        ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('process.name')->label('Proceso'),
            Tables\Columns\TextColumn::make('complexity'),
            Tables\Columns\TextColumn::make('risk'),
            Tables\Columns\TextColumn::make('impact'),
            Tables\Columns\TextColumn::make('estimated_hours'),
        ])->actions([
            Tables\Actions\EditAction::make(),
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
