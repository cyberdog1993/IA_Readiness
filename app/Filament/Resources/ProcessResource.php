<?php

namespace App\Filament\Resources;

use App\Models\ProcessModel;
use Filament\Forms\Form;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ViewColumn;
use Filament\Tables\Table;

class ProcessResource extends Resource
{
    protected static ?string $model = ProcessModel::class;
    protected static ?string $navigationGroup = 'Automatización';
    protected static ?string $navigationLabel = 'Procesos';
    protected static ?string $modelLabel = 'proceso';
    protected static ?string $pluralModelLabel = 'procesos';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Select::make('lead_id')->label('Prospecto')->relationship('lead', 'company_name'),
            Select::make('client_id')->label('Cliente')->relationship('client', 'business_name'),
            TextInput::make('name')->label('Nombre del proceso')->required(),
            TextInput::make('area')->label('Área'),
            TextInput::make('owner')->label('Responsable'),
            TextInput::make('frequency')->label('Frecuencia'),
            Textarea::make('objective')->label('Objetivo')->columnSpanFull(),
            Textarea::make('expected_result')->label('Resultado esperado')->columnSpanFull(),
            Textarea::make('trigger_event')->label('Evento inicial')->columnSpanFull(),
            Textarea::make('validation_method')->label('Validación de cierre')->columnSpanFull(),
            TextInput::make('status')->label('Estado'),
        ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('name')->label('Proceso')->searchable()->sortable(),
            Tables\Columns\TextColumn::make('area')->label('Área'),
            Tables\Columns\TextColumn::make('owner')->label('Responsable'),
            Tables\Columns\TextColumn::make('status')->label('Estado'),
            ViewColumn::make('exportar')->label('Exportar')->view('filament.tables.export-actions'),
        ])->actions([
            Tables\Actions\EditAction::make()->label('Editar')->button(),
        ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ProcessResource\Pages\ListProcesses::route('/'),
            'create' => ProcessResource\Pages\CreateProcess::route('/create'),
            'edit' => ProcessResource\Pages\EditProcess::route('/{record}/edit'),
        ];
    }
}
