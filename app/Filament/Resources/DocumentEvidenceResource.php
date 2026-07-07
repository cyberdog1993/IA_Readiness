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

    public static function form(Form $form): Form
    {
        return $form->schema([
            Select::make('process_id')->relationship('process', 'name'),
            TextInput::make('name')->required(),
            TextInput::make('type'),
            TextInput::make('format'),
            TextInput::make('location'),
            TextInput::make('owner'),
            Toggle::make('mandatory'),
            TextInput::make('notes')->columnSpanFull(),
        ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('name')->searchable(),
            Tables\Columns\TextColumn::make('type'),
            Tables\Columns\TextColumn::make('format'),
            Tables\Columns\IconColumn::make('mandatory')->boolean(),
        ])->actions([
            Tables\Actions\EditAction::make(),
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
