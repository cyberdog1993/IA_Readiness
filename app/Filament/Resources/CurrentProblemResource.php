<?php

namespace App\Filament\Resources;

use App\Models\CurrentProblem;
use Filament\Forms\Form;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class CurrentProblemResource extends Resource
{
    protected static ?string $model = CurrentProblem::class;
    protected static ?string $navigationGroup = 'Automatización';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Select::make('process_id')->relationship('process', 'name'),
            Textarea::make('description')->columnSpanFull()->required(),
            TextInput::make('impact'),
            TextInput::make('frequency'),
            TextInput::make('risk'),
            Textarea::make('comments')->columnSpanFull(),
        ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('process.name')->label('Proceso'),
            Tables\Columns\TextColumn::make('description')->limit(50),
            Tables\Columns\TextColumn::make('impact'),
            Tables\Columns\TextColumn::make('risk'),
        ])->actions([
            Tables\Actions\EditAction::make(),
        ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => CurrentProblemResource\Pages\ListCurrentProblems::route('/'),
            'create' => CurrentProblemResource\Pages\CreateCurrentProblem::route('/create'),
            'edit' => CurrentProblemResource\Pages\EditCurrentProblem::route('/{record}/edit'),
        ];
    }
}
