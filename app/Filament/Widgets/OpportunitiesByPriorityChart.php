<?php

namespace App\Filament\Widgets;

use App\Models\AutomationOpportunity;
use Filament\Widgets\ChartWidget;

class OpportunitiesByPriorityChart extends ChartWidget
{
    protected static ?string $heading = 'Oportunidades por prioridad';

    protected function getData(): array
    {
        $priorities = AutomationOpportunity::query()
            ->selectRaw('priority, count(*) as total')
            ->groupBy('priority')
            ->pluck('total', 'priority')
            ->toArray();

        return [
            'datasets' => [
                [
                    'label' => 'Oportunidades',
                    'data' => array_values($priorities),
                    'backgroundColor' => ['#3b82f6', '#10b981', '#f59e0b', '#ef4444'],
                ],
            ],
            'labels' => array_keys($priorities),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}

