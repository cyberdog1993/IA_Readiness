<?php

namespace App\Filament\Resources;

use App\Models\Client;
use Filament\Forms\Form;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ClientResource extends Resource
{
    protected static ?string $model = Client::class;
    protected static ?string $navigationGroup = 'Clientes';
    protected static ?string $navigationLabel = 'Clientes';
    protected static ?string $modelLabel = 'cliente';
    protected static ?string $pluralModelLabel = 'clientes';

    public static function form(Form $form): Form
    {
        return $form->schema([
            TextInput::make('business_name')->label('Razón social')->required(),
            TextInput::make('ruc')->label('RUC')->required(),
            TextInput::make('industry')->label('Rubro')->required(),
            TextInput::make('address')->label('Dirección'),
            TextInput::make('main_contact')->label('Contacto principal'),
            TextInput::make('contact_role')->label('Cargo'),
            TextInput::make('email')->label('Correo')->email(),
            TextInput::make('phone')->label('Teléfono'),
            TextInput::make('status')->label('Estado'),
            Textarea::make('notes')->label('Observaciones')->columnSpanFull(),
        ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('business_name')->label('Razón social')->searchable()->sortable(),
            Tables\Columns\TextColumn::make('ruc')->label('RUC')->searchable(),
            Tables\Columns\TextColumn::make('industry')->label('Rubro'),
            Tables\Columns\TextColumn::make('status')->label('Estado'),
        ])->actions([
            Tables\Actions\EditAction::make()->label('Editar'),
        ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ClientResource\Pages\ListClients::route('/'),
            'create' => ClientResource\Pages\CreateClient::route('/create'),
            'edit' => ClientResource\Pages\EditClient::route('/{record}/edit'),
        ];
    }
}
