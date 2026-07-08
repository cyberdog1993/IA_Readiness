<?php

namespace App\Filament\Resources;

use App\Models\BacklogItem;
use Filament\Forms\Form;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class BacklogItemResource extends Resource
{
    protected static ?string $model = BacklogItem::class;
    protected static ?string $navigationGroup = 'Administración';
    protected static ?string $navigationLabel = 'Tareas';
    protected static ?string $modelLabel = 'tarea';
    protected static ?string $pluralModelLabel = 'tareas';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Select::make('process_id')->label('Proceso')->relationship('process', 'name'),
            TextInput::make('type')->label('Tipo')->required(),
            TextInput::make('title')->label('Título')->required(),
            Textarea::make('description')->label('Descripción')->columnSpanFull(),
            Textarea::make('acceptance_criteria')->label('Criterios de aceptación')->columnSpanFull(),
            TextInput::make('priority')->label('Prioridad'),
            TextInput::make('responsible')->label('Responsable'),
            TextInput::make('status')->label('Estado'),
            TextInput::make('estimated_hours')->label('Horas estimadas')->numeric(),
        ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('process.name')->label('Proceso'),
            Tables\Columns\TextColumn::make('title')->label('Título')->searchable(),
            Tables\Columns\TextColumn::make('type')->label('Tipo'),
            Tables\Columns\TextColumn::make('priority')->label('Prioridad'),
            Tables\Columns\TextColumn::make('status')->label('Estado'),
        ])->actions([
            Tables\Actions\EditAction::make()->label('Editar'),
        ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => BacklogItemResource\Pages\ListBacklogItems::route('/'),
            'create' => BacklogItemResource\Pages\CreateBacklogItem::route('/create'),
            'edit' => BacklogItemResource\Pages\EditBacklogItem::route('/{record}/edit'),
        ];
    }
}
