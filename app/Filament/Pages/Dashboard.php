<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\AutomationStatsOverview;
use Filament\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{
    protected function getHeaderWidgets(): array
    {
        return [
            AutomationStatsOverview::class,
            \App\Filament\Widgets\OpportunitiesByPriorityChart::class,
        ];
    }
}
