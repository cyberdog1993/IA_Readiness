<?php

namespace App\Filament\Resources;

use App\Models\User;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Get;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class UserResource extends Resource
{
    protected static ?string $model = User::class;
    protected static ?string $navigationGroup = 'Administración';
    protected static ?string $navigationLabel = 'Usuarios';
    protected static ?string $modelLabel = 'usuario';
    protected static ?string $pluralModelLabel = 'usuarios';
    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    protected static ?int $navigationSort = 30;

    public static function form(Form $form): Form
    {
        return $form->schema([
            TextInput::make('name')->label('Nombre')->required(),
            TextInput::make('email')->label('Correo')->email()->required(),
            Select::make('role')
                ->label('Rol')
                ->options([
                    'admin' => 'Administrador',
                    'internal' => 'Consultor interno',
                    'client' => 'Cliente',
                ])
                ->required()
                ->default('internal')
                ->live(),
            Select::make('client_id')
                ->label('Cliente')
                ->relationship('client', 'business_name')
                ->searchable()
                ->preload()
                ->helperText('Vincula el acceso al cliente para que solo pueda entrar a su formulario.')
                ->visible(fn (Get $get): bool => $get('role') === 'client'),
            TextInput::make('password')
                ->label('Contraseña')
                ->password()
                ->required(fn (string $operation): bool => $operation === 'create')
                ->dehydrated(fn ($state): bool => filled($state))
                ->revealable(),
        ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('name')->label('Nombre')->searchable()->sortable(),
            Tables\Columns\TextColumn::make('email')->label('Correo')->searchable(),
            Tables\Columns\TextColumn::make('role')->label('Rol'),
            Tables\Columns\TextColumn::make('client.business_name')->label('Cliente'),
        ])->actions([
            Tables\Actions\EditAction::make()->label('Editar'),
        ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => UserResource\Pages\ListUsers::route('/'),
            'create' => UserResource\Pages\CreateUser::route('/create'),
            'edit' => UserResource\Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
