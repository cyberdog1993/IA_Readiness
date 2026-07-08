<?php

namespace App\Filament\Widgets;

use App\Models\AutomationOpportunity;
use App\Models\Lead;
use App\Models\ProcessModel;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class AutomationStatsOverview extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        $leads = Lead::count();
        $averageMaturity = (int) round(Lead::avg('maturity_score') ?? 0);
        $processes = ProcessModel::count();
        $currentMinutes = (int) AutomationOpportunity::sum('current_time_minutes');
        $expectedMinutes = (int) AutomationOpportunity::sum('expected_time_minutes');
        $savings = max(0, $currentMinutes - $expectedMinutes);

        return [
            Stat::make('Prospectos recibidos', $leads),
            Stat::make('Promedio de madurez', $averageMaturity.' / 100'),
            Stat::make('Procesos registrados', $processes),
            Stat::make('Horas actuales estimadas', number_format($currentMinutes / 60, 1)),
            Stat::make('Horas esperadas post-automatización', number_format($expectedMinutes / 60, 1)),
            Stat::make('Ahorro estimado', number_format($savings / 60, 1)),
        ];
    }
}
