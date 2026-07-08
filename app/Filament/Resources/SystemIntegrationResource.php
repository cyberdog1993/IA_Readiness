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
    protected static ?string $navigationLabel = 'Sistemas';
    protected static ?string $modelLabel = 'sistema';
    protected static ?string $pluralModelLabel = 'sistemas';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Select::make('client_id')->label('Cliente')->relationship('client', 'business_name'),
            Select::make('process_id')->label('Proceso')->relationship('process', 'name'),
            TextInput::make('name')->label('Nombre del sistema')->required(),
            TextInput::make('url')->label('URL'),
            TextInput::make('system_type')->label('Tipo de sistema'),
            Toggle::make('has_api')->label('Tiene API'),
            TextInput::make('auth_type')->label('Tipo de autenticación'),
            TextInput::make('access_owner')->label('Responsable del acceso'),
            TextInput::make('access_status')->label('Estado del acceso'),
            TextInput::make('notes')->label('Observaciones')->columnSpanFull(),
        ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('name')->label('Sistema')->searchable(),
            Tables\Columns\TextColumn::make('system_type')->label('Tipo'),
            Tables\Columns\IconColumn::make('has_api')->label('API')->boolean(),
            Tables\Columns\TextColumn::make('access_status')->label('Estado del acceso'),
        ])->actions([
            Tables\Actions\EditAction::make()->label('Editar'),
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
