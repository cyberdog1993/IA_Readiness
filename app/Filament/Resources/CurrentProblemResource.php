<?php

namespace App\Filament\Resources;

use App\Models\CurrentProblem;
use Filament\Forms\Form;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class CurrentProblemResource extends Resource
{
    protected static ?string $model = CurrentProblem::class;
    protected static ?string $navigationGroup = 'Automatización';
    protected static ?string $navigationLabel = 'Problemas actuales';
    protected static ?string $modelLabel = 'problema actual';
    protected static ?string $pluralModelLabel = 'problemas actuales';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Select::make('process_id')->label('Proceso')->relationship('process', 'name'),
            Textarea::make('description')->label('Descripción')->columnSpanFull()->required(),
            TextInput::make('impact')->label('Impacto'),
            TextInput::make('frequency')->label('Frecuencia'),
            TextInput::make('risk')->label('Riesgo'),
            Textarea::make('comments')->label('Comentarios')->columnSpanFull(),
        ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('process.name')->label('Proceso'),
            Tables\Columns\TextColumn::make('description')->label('Descripción')->limit(50),
            Tables\Columns\TextColumn::make('impact')->label('Impacto'),
            Tables\Columns\TextColumn::make('risk')->label('Riesgo'),
        ])->actions([
            Tables\Actions\EditAction::make()->label('Editar'),
        ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => CurrentProblemResource\Pages\ListCurrentProblems::route('/'),
            'create' => CurrentProblemResource\Pages\CreateCurrentProblem::route('/create'),
            'edit' => CurrentProblemResource\Pages\EditCurrentProblem::route('/{record}/edit'),
        ];
    }
}
