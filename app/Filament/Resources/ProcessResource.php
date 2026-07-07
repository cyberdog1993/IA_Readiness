<?php

namespace App\Filament\Resources;

use App\Models\ProcessModel;
use Filament\Forms\Form;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ProcessResource extends Resource
{
    protected static ?string $model = ProcessModel::class;
    protected static ?string $navigationGroup = 'Automatización';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Select::make('lead_id')->relationship('lead', 'company_name'),
            Select::make('client_id')->relationship('client', 'business_name'),
            TextInput::make('name')->required(),
            TextInput::make('area'),
            TextInput::make('owner'),
            TextInput::make('frequency'),
            Textarea::make('objective')->columnSpanFull(),
            Textarea::make('expected_result')->columnSpanFull(),
            Textarea::make('trigger_event')->columnSpanFull(),
            Textarea::make('validation_method')->columnSpanFull(),
            TextInput::make('status'),
        ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('name')->searchable()->sortable(),
            Tables\Columns\TextColumn::make('area'),
            Tables\Columns\TextColumn::make('owner'),
            Tables\Columns\TextColumn::make('status'),
        ])->actions([
            Tables\Actions\EditAction::make(),
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
