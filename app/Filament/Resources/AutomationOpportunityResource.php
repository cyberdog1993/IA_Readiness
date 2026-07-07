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

    public static function form(Form $form): Form
    {
        return $form->schema([
            Select::make('process_id')->relationship('process', 'name'),
            TextInput::make('activity')->required(),
            TextInput::make('current_time_minutes')->numeric(),
            TextInput::make('expected_time_minutes')->numeric(),
            TextInput::make('estimated_savings_minutes')->numeric(),
            TextInput::make('suggested_technology'),
            TextInput::make('priority'),
            TextInput::make('complexity')->numeric(),
            TextInput::make('status'),
            Textarea::make('notes')->columnSpanFull(),
        ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('process.name')->label('Proceso'),
            Tables\Columns\TextColumn::make('activity'),
            Tables\Columns\TextColumn::make('priority'),
            Tables\Columns\TextColumn::make('estimated_savings_minutes'),
            Tables\Columns\TextColumn::make('status'),
        ])->actions([
            Tables\Actions\EditAction::make(),
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
