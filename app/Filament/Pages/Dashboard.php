<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\AutomationStatsOverview;
use Filament\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{
    protected static string $view = 'filament.pages.dashboard';
    protected static ?string $navigationLabel = 'Escritorio';
    protected static ?string $title = 'Escritorio';
    protected static ?string $navigationIcon = 'heroicon-o-home';

    public function getWidgets(): array
    {
        return [
            AutomationStatsOverview::class,
            \App\Filament\Widgets\OpportunitiesByPriorityChart::class,
        ];
    }

    public function getColumns(): int | string | array
    {
        return [
            'md' => 2,
            'xl' => 3,
        ];
    }
}
