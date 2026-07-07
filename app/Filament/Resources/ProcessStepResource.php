<?php

namespace App\Filament\Resources;

use App\Models\ProcessStep;
use Filament\Forms\Form;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ProcessStepResource extends Resource
{
    protected static ?string $model = ProcessStep::class;
    protected static ?string $navigationGroup = 'Automatización';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Select::make('process_id')->relationship('process', 'name')->required(),
            TextInput::make('step_number')->numeric()->required(),
            Textarea::make('description')->columnSpanFull()->required(),
            TextInput::make('owner'),
            TextInput::make('system_used'),
            Textarea::make('input')->columnSpanFull(),
            Textarea::make('output')->columnSpanFull(),
            TextInput::make('estimated_minutes')->numeric(),
            Textarea::make('evidence_generated')->columnSpanFull(),
            Textarea::make('problems')->columnSpanFull(),
            TextInput::make('automatable'),
            Textarea::make('comments')->columnSpanFull(),
        ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('process.name')->label('Proceso'),
            Tables\Columns\TextColumn::make('step_number'),
            Tables\Columns\TextColumn::make('description')->limit(50),
            Tables\Columns\TextColumn::make('system_used'),
            Tables\Columns\TextColumn::make('estimated_minutes'),
            Tables\Columns\TextColumn::make('automatable'),
        ])->actions([
            Tables\Actions\EditAction::make(),
        ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ProcessStepResource\Pages\ListProcessSteps::route('/'),
            'create' => ProcessStepResource\Pages\CreateProcessStep::route('/create'),
            'edit' => ProcessStepResource\Pages\EditProcessStep::route('/{record}/edit'),
        ];
    }
}
