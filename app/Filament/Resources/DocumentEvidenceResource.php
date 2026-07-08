<?php

namespace App\Filament\Resources;

use App\Models\DocumentEvidence;
use Filament\Forms\Form;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class DocumentEvidenceResource extends Resource
{
    protected static ?string $model = DocumentEvidence::class;
    protected static ?string $navigationGroup = 'Automatización';
    protected static ?string $navigationLabel = 'Documentos';
    protected static ?string $modelLabel = 'documento';
    protected static ?string $pluralModelLabel = 'documentos';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Select::make('process_id')->label('Proceso')->relationship('process', 'name'),
            TextInput::make('name')->label('Nombre')->required(),
            TextInput::make('type')->label('Tipo'),
            TextInput::make('format')->label('Formato'),
            TextInput::make('location')->label('Ubicación'),
            TextInput::make('owner')->label('Responsable'),
            Toggle::make('mandatory')->label('Obligatorio'),
            TextInput::make('notes')->label('Observaciones')->columnSpanFull(),
        ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('name')->label('Nombre')->searchable(),
            Tables\Columns\TextColumn::make('type')->label('Tipo'),
            Tables\Columns\TextColumn::make('format')->label('Formato'),
            Tables\Columns\IconColumn::make('mandatory')->label('Obligatorio')->boolean(),
        ])->actions([
            Tables\Actions\EditAction::make()->label('Editar'),
        ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => DocumentEvidenceResource\Pages\ListDocumentEvidences::route('/'),
            'create' => DocumentEvidenceResource\Pages\CreateDocumentEvidence::route('/create'),
            'edit' => DocumentEvidenceResource\Pages\EditDocumentEvidence::route('/{record}/edit'),
        ];
    }
}
