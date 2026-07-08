<?php

namespace App\Filament\Resources;

use App\Models\AutomationOpportunity;
use Filament\Forms\Form;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class AutomationOpportunityResource extends Resource
{
    protected static ?string $model = AutomationOpportunity::class;
    protected static ?string $navigationGroup = 'Automatización';
    protected static ?string $navigationLabel = 'Oportunidades';
    protected static ?string $modelLabel = 'oportunidad';
    protected static ?string $pluralModelLabel = 'oportunidades';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Select::make('process_id')->label('Proceso')->relationship('process', 'name'),
            TextInput::make('activity')->label('Actividad')->required(),
            TextInput::make('current_time_minutes')->label('Tiempo actual en minutos')->numeric(),
            TextInput::make('expected_time_minutes')->label('Tiempo esperado en minutos')->numeric(),
            TextInput::make('estimated_savings_minutes')->label('Ahorro estimado en minutos')->numeric(),
            TextInput::make('suggested_technology')->label('Tecnología sugerida'),
            TextInput::make('priority')->label('Prioridad'),
            TextInput::make('complexity')->label('Complejidad')->numeric(),
            TextInput::make('status')->label('Estado'),
            Textarea::make('notes')->label('Observaciones')->columnSpanFull(),
        ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('process.name')->label('Proceso'),
            Tables\Columns\TextColumn::make('activity')->label('Actividad'),
            Tables\Columns\TextColumn::make('priority')->label('Prioridad'),
            Tables\Columns\TextColumn::make('estimated_savings_minutes')->label('Ahorro min.'),
            Tables\Columns\TextColumn::make('status')->label('Estado'),
        ])->actions([
            Tables\Actions\EditAction::make()->label('Editar'),
        ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => AutomationOpportunityResource\Pages\ListAutomationOpportunities::route('/'),
            'create' => AutomationOpportunityResource\Pages\CreateAutomationOpportunity::route('/create'),
            'edit' => AutomationOpportunityResource\Pages\EditAutomationOpportunity::route('/{record}/edit'),
        ];
    }
}
