<?php

namespace App\Filament\Widgets;

use App\Models\Visite;
use Filament\Widgets\ChartWidget;

class VisitesParRegionChart extends ChartWidget
{
    protected static ?int $sort = 4;

    protected static bool $isLazy = false;

    protected ?string $heading = 'Visites par région';

    protected ?string $description = 'Mois en cours';

    protected ?string $maxHeight = '280px';

    protected function getData(): array
    {
        $rows = Visite::query()
            ->where('created_at', '>=', now()->startOfMonth())
            ->get(['region'])
            ->groupBy(fn (Visite $visite) => $visite->region ?: 'Non renseignée')
            ->map->count()
            ->sortDesc();

        return [
            'datasets' => [
                [
                    'label' => 'Visites',
                    'data' => $rows->values()->all(),
                    'backgroundColor' => ['#0b2a5b', '#e31c23', '#0f766e', '#1d4ed8', '#b45309', '#64748b', '#7c3aed'],
                ],
            ],
            'labels' => $rows->keys()->all(),
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }

    protected function getOptions(): array
    {
        return [
            'plugins' => [
                'legend' => [
                    'position' => 'bottom',
                ],
            ],
        ];
    }
}
