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

    public static function form(Form $form): Form
    {
        return $form->schema([
            Select::make('process_id')->relationship('process', 'name'),
            TextInput::make('type')->required(),
            TextInput::make('title')->required(),
            Textarea::make('description')->columnSpanFull(),
            Textarea::make('acceptance_criteria')->columnSpanFull(),
            TextInput::make('priority'),
            TextInput::make('responsible'),
            TextInput::make('status'),
            TextInput::make('estimated_hours')->numeric(),
        ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('process.name')->label('Proceso'),
            Tables\Columns\TextColumn::make('title')->searchable(),
            Tables\Columns\TextColumn::make('type'),
            Tables\Columns\TextColumn::make('priority'),
            Tables\Columns\TextColumn::make('status'),
        ])->actions([
            Tables\Actions\EditAction::make(),
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
