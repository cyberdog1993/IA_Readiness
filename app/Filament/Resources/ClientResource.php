<?php

namespace App\Filament\Resources;

use App\Models\Lead;
use App\Models\Client;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ViewColumn;
use Filament\Tables\Table;
use Filament\Forms\Set;

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
            Select::make('lead_id')
                ->label('Prospecto origen')
                ->relationship('lead', 'company_name')
                ->searchable()
                ->preload()
                ->live()
                ->helperText('Selecciona el prospecto para traer su información y arrancar desde el pre-formulario.')
                ->afterStateUpdated(function (Set $set, ?string $state): void {
                    $lead = $state ? Lead::find($state) : null;

                    if (! $lead) {
                        return;
                    }

                    $set('business_name', $lead->company_name);
                    $set('ruc', $lead->ruc);
                    $set('industry', $lead->industry);
                    $set('main_contact', $lead->contact_name);
                    $set('contact_role', $lead->contact_role);
                    $set('email', $lead->email);
                    $set('phone', $lead->phone);
                }),
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
            ViewColumn::make('exportar')->label('Exportar')->view('filament.tables.export-actions'),
        ])->actions([
            Tables\Actions\EditAction::make()->label('Editar')->button(),
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
