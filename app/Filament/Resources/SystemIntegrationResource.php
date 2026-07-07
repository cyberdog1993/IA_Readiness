<?php

namespace App\Filament\Resources;

use App\Models\SystemIntegration;
use Filament\Forms\Form;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class SystemIntegrationResource extends Resource
{
    protected static ?string $model = SystemIntegration::class;
    protected static ?string $navigationGroup = 'Automatización';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Select::make('client_id')->relationship('client', 'business_name'),
            Select::make('process_id')->relationship('process', 'name'),
            TextInput::make('name')->required(),
            TextInput::make('url'),
            TextInput::make('system_type'),
            Toggle::make('has_api'),
            TextInput::make('auth_type'),
            TextInput::make('access_owner'),
            TextInput::make('access_status'),
            TextInput::make('notes')->columnSpanFull(),
        ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('name')->searchable(),
            Tables\Columns\TextColumn::make('system_type'),
            Tables\Columns\IconColumn::make('has_api')->boolean(),
            Tables\Columns\TextColumn::make('access_status'),
        ])->actions([
            Tables\Actions\EditAction::make(),
        ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => SystemIntegrationResource\Pages\ListSystemIntegrations::route('/'),
            'create' => SystemIntegrationResource\Pages\CreateSystemIntegration::route('/create'),
            'edit' => SystemIntegrationResource\Pages\EditSystemIntegration::route('/{record}/edit'),
        ];
    }
}
