<?php

namespace App\Filament\Widgets;

use App\Models\Visite;
use Filament\Widgets\ChartWidget;

class VisitesParJourChart extends ChartWidget
{
    protected static ?int $sort = 2;

    protected static bool $isLazy = false;

    protected ?string $heading = 'Visites par jour';

    protected ?string $description = '30 derniers jours';

    protected int|string|array $columnSpan = 'full';

    protected ?string $maxHeight = '280px';

    protected function getData(): array
    {
        $start = now()->subDays(29)->startOfDay();
        $counts = Visite::query()
            ->where('created_at', '>=', $start)
            ->get(['created_at'])
            ->groupBy(fn (Visite $visite) => $visite->created_at->toDateString())
            ->map->count();

        $labels = [];
        $data = [];
        for ($day = 0; $day < 30; $day++) {
            $date = $start->copy()->addDays($day);
            $labels[] = $date->format('d/m');
            $data[] = (int) ($counts[$date->toDateString()] ?? 0);
        }

        return [
            'datasets' => [
                [
                    'label' => 'Visites',
                    'data' => $data,
                    'borderColor' => '#0b2a5b',
                    'backgroundColor' => 'rgba(11, 42, 91, 0.12)',
                    'fill' => true,
                    'tension' => 0.35,
                    'borderWidth' => 2,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }

    protected function getOptions(): array
    {
        return [
            'plugins' => [
                'legend' => ['display' => false],
            ],
            'scales' => [
                'x' => [
                    'grid' => ['display' => false],
                    'ticks' => ['maxRotation' => 0, 'autoSkip' => true, 'maxTicksLimit' => 8],
                ],
                'y' => [
                    'beginAtZero' => true,
                    'ticks' => ['precision' => 0],
                    'grid' => ['color' => 'rgba(11, 42, 91, 0.08)'],
                ],
            ],
            'elements' => [
                'point' => ['radius' => 0, 'hitRadius' => 10],
            ],
        ];
    }
}
