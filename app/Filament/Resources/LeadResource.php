<?php

namespace App\Filament\Resources;

use App\Models\Lead;
use Filament\Forms\Form;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\Section;

class LeadResource extends Resource
{
    protected static ?string $model = Lead::class;
    protected static ?string $navigationGroup = 'Ventas';
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Section::make('Datos del lead')->schema([
                TextInput::make('company_name')->required(),
                TextInput::make('ruc')->required(),
                TextInput::make('industry')->required(),
                TextInput::make('contact_name')->required(),
                TextInput::make('contact_role')->required(),
                TextInput::make('email')->email()->required(),
                TextInput::make('phone')->required(),
                TextInput::make('company_size')->required(),
                TextInput::make('repetitive_process_count')->numeric()->required(),
                TextInput::make('manual_hours_weekly')->numeric()->required(),
                TextInput::make('process_documentation_level')->numeric()->required(),
                TextInput::make('digital_system_usage')->numeric()->required(),
                TextInput::make('excel_dependency')->numeric()->required(),
                TextInput::make('system_integration_level')->numeric()->required(),
                TextInput::make('manual_report_generation')->numeric()->required(),
                Toggle::make('has_kpis'),
                TextInput::make('key_person_dependency')->numeric()->required(),
                TextInput::make('automation_interest')->numeric()->required(),
                TextInput::make('maturity_score')->numeric(),
                TextInput::make('maturity_level'),
                Textarea::make('diagnosis_brief')->columnSpanFull(),
                Textarea::make('opportunities_summary')->columnSpanFull(),
                Textarea::make('recommendation')->columnSpanFull(),
                TextInput::make('status'),
            ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('company_name')->searchable()->sortable(),
            Tables\Columns\TextColumn::make('ruc')->searchable(),
            Tables\Columns\TextColumn::make('maturity_score')->sortable(),
            Tables\Columns\TextColumn::make('maturity_level'),
            Tables\Columns\TextColumn::make('status'),
            Tables\Columns\TextColumn::make('created_at')->dateTime()->since(),
        ])->actions([
            Tables\Actions\EditAction::make(),
        ])->bulkActions([
            Tables\Actions\DeleteBulkAction::make(),
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
