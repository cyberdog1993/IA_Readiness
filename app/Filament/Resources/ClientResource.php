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

    public static function form(Form $form): Form
    {
        return $form->schema([
            TextInput::make('business_name')->required(),
            TextInput::make('ruc')->required(),
            TextInput::make('industry')->required(),
            TextInput::make('address'),
            TextInput::make('main_contact'),
            TextInput::make('contact_role'),
            TextInput::make('email')->email(),
            TextInput::make('phone'),
            TextInput::make('status'),
            Textarea::make('notes')->columnSpanFull(),
        ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('business_name')->searchable()->sortable(),
            Tables\Columns\TextColumn::make('ruc')->searchable(),
            Tables\Columns\TextColumn::make('industry'),
            Tables\Columns\TextColumn::make('status'),
        ])->actions([
            Tables\Actions\EditAction::make(),
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
