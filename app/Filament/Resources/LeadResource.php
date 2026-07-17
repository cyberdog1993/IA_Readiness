<?php

namespace App\Filament\Resources;

use App\Models\Lead;
use Filament\Forms\Form;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ViewColumn;
use Filament\Tables\Table;
use Filament\Forms\Components\Section;

class LeadResource extends Resource
{
    protected static ?string $model = Lead::class;
    protected static ?string $navigationGroup = 'Ventas';
    protected static ?string $navigationLabel = 'Prospectos';
    protected static ?string $modelLabel = 'prospecto';
    protected static ?string $pluralModelLabel = 'prospectos';
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Section::make('Datos del prospecto')->schema([
                TextInput::make('company_name')->label('Empresa')->required(),
                TextInput::make('ruc')->label('RUC')->required(),
                TextInput::make('industry')->label('Rubro')->required(),
                TextInput::make('contact_name')->label('Contacto')->required(),
                TextInput::make('contact_role')->label('Cargo')->required(),
                TextInput::make('email')->label('Correo')->email()->required(),
                TextInput::make('phone')->label('Teléfono')->required(),
                TextInput::make('company_size')->label('Tamaño de empresa')->required(),
                TextInput::make('repetitive_process_count')->label('Procesos repetitivos')->numeric()->required(),
                TextInput::make('manual_hours_weekly')->label('Horas manuales semanales')->numeric()->required(),
                TextInput::make('process_documentation_level')->label('Nivel de documentación')->numeric()->required(),
                TextInput::make('digital_system_usage')->label('Uso de sistemas digitales')->numeric()->required(),
                TextInput::make('excel_dependency')->label('Dependencia de Excel')->numeric()->required(),
                TextInput::make('system_integration_level')->label('Nivel de integración')->numeric()->required(),
                TextInput::make('manual_report_generation')->label('Reportes manuales')->numeric()->required(),
                Toggle::make('has_kpis')->label('Tiene KPIs'),
                TextInput::make('key_person_dependency')->label('Dependencia de personas clave')->numeric()->required(),
                TextInput::make('automation_interest')->label('Interés en automatizar')->numeric()->required(),
                TextInput::make('maturity_score')->label('Puntaje de madurez')->numeric(),
                TextInput::make('maturity_level')->label('Nivel de madurez'),
                Textarea::make('diagnosis_brief')->label('Diagnóstico breve')->columnSpanFull(),
                Textarea::make('opportunities_summary')->label('Oportunidades principales')->columnSpanFull(),
                Textarea::make('recommendation')->label('Recomendación')->columnSpanFull(),
                TextInput::make('status')->label('Estado'),
            ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('company_name')->label('Empresa')->searchable()->sortable(),
            Tables\Columns\TextColumn::make('ruc')->label('RUC')->searchable(),
            Tables\Columns\TextColumn::make('maturity_score')->label('Puntaje')->sortable(),
            Tables\Columns\TextColumn::make('maturity_level')->label('Nivel'),
            Tables\Columns\TextColumn::make('status')->label('Estado'),
            Tables\Columns\TextColumn::make('created_at')->label('Recibido')->dateTime()->since(),
            ViewColumn::make('exportar')->label('Exportar')->view('filament.tables.export-actions'),
        ])->actions([
            Tables\Actions\EditAction::make()->label('Editar')->button(),
        ])->bulkActions([
            Tables\Actions\DeleteBulkAction::make()->label('Eliminar seleccionados'),
        ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => LeadResource\Pages\ListLeads::route('/'),
            'create' => LeadResource\Pages\CreateLead::route('/create'),
            'edit' => LeadResource\Pages\EditLead::route('/{record}/edit'),
        ];
    }
}
