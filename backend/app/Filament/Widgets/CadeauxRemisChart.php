<?php

namespace App\Filament\Widgets;

use App\Models\Cadeau;
use App\Models\VisiteCadeau;
use Filament\Widgets\ChartWidget;

class CadeauxRemisChart extends ChartWidget
{
    protected static ?int $sort = 3;

    protected static bool $isLazy = false;

    protected ?string $heading = 'Cadeaux remis';

    protected ?string $description = 'Quantités du mois en cours';

    protected ?string $maxHeight = '280px';

    protected function getData(): array
    {
        $rows = VisiteCadeau::query()
            ->selectRaw('cadeau_id, SUM(qty) as total')
            ->whereHas('visite', fn ($query) => $query->where('created_at', '>=', now()->startOfMonth()))
            ->groupBy('cadeau_id')
            ->orderByDesc('total')
            ->get();

        $names = Cadeau::query()->whereIn('id', $rows->pluck('cadeau_id'))->pluck('name', 'id');

        return [
            'datasets' => [
                [
                    'label' => 'Quantité',
                    'data' => $rows->pluck('total')->map(fn ($total) => (int) $total)->all(),
                    'backgroundColor' => $rows->values()->map(
                        fn ($row, int $index) => $index === 0 ? '#e31c23' : '#0b2a5b'
                    )->all(),
                    'borderRadius' => 6,
                ],
            ],
            'labels' => $rows->map(fn ($row) => $names[$row->cadeau_id] ?? 'Cadeau')->all(),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }

    protected function getOptions(): array
    {
        return [
            'indexAxis' => 'y',
            'plugins' => [
                'legend' => ['display' => false],
            ],
            'scales' => [
                'x' => [
                    'beginAtZero' => true,
                    'ticks' => ['precision' => 0],
                    'grid' => ['color' => 'rgba(11, 42, 91, 0.08)'],
                ],
                'y' => [
                    'grid' => ['display' => false],
                ],
            ],
        ];
    }
}
