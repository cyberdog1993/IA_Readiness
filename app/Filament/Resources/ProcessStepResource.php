<?php

namespace App\Filament\Resources;

use App\Models\ProcessStep;
use Filament\Forms\Form;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ProcessStepResource extends Resource
{
    protected static ?string $model = ProcessStep::class;
    protected static ?string $navigationGroup = 'Automatización';
    protected static ?string $navigationLabel = 'Pasos AS-IS';
    protected static ?string $modelLabel = 'paso AS-IS';
    protected static ?string $pluralModelLabel = 'pasos AS-IS';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Select::make('process_id')->label('Proceso')->relationship('process', 'name')->required(),
            TextInput::make('step_number')->label('Número de paso')->numeric()->required(),
            Textarea::make('description')->label('Descripción')->columnSpanFull()->required(),
            TextInput::make('owner')->label('Responsable'),
            TextInput::make('system_used')->label('Sistema usado'),
            Textarea::make('input')->label('Entrada')->columnSpanFull(),
            Textarea::make('output')->label('Salida')->columnSpanFull(),
            TextInput::make('estimated_minutes')->label('Minutos estimados')->numeric(),
            Textarea::make('evidence_generated')->label('Evidencia generada')->columnSpanFull(),
            Textarea::make('problems')->label('Problemas')->columnSpanFull(),
            TextInput::make('automatable')->label('Automatizable'),
            Textarea::make('comments')->label('Comentarios')->columnSpanFull(),
        ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('process.name')->label('Proceso'),
            Tables\Columns\TextColumn::make('step_number')->label('Paso'),
            Tables\Columns\TextColumn::make('description')->label('Descripción')->limit(50),
            Tables\Columns\TextColumn::make('system_used')->label('Sistema'),
            Tables\Columns\TextColumn::make('estimated_minutes')->label('Minutos'),
            Tables\Columns\TextColumn::make('automatable')->label('Automatizable'),
        ])->actions([
            Tables\Actions\EditAction::make()->label('Editar'),
        ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ProcessStepResource\Pages\ListProcessSteps::route('/'),
            'create' => ProcessStepResource\Pages\CreateProcessStep::route('/create'),
            'edit' => ProcessStepResource\Pages\EditProcessStep::route('/{record}/edit'),
        ];
    }
}
