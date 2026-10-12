<?php

namespace App\Filament\Widgets;

use App\Models\Cadeau;
use App\Models\Medecin;
use App\Models\User;
use App\Models\Visite;
use App\Models\VisiteCadeau;
use Filament\Support\Enums\IconPosition;
use Filament\Support\Icons\Heroicon;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class TourneeStats extends StatsOverviewWidget
{
    protected static ?int $sort = -4;

    protected static bool $isLazy = false;

    protected int|array|null $columns = [
        'md' => 2,
        'xl' => 3,
    ];

    protected function getStats(): array
    {
        $from = now()->startOfMonth();
        $todayCount = Visite::query()->whereDate('created_at', today())->count();
        $yesterdayCount = Visite::query()->whereDate('created_at', today()->subDay())->count();
        $delta = $todayCount - $yesterdayCount;

        $last7 = collect(range(6, 0))->map(
            fn (int $days) => Visite::query()->whereDate('created_at', now()->subDays($days))->count()
        )->all();

        $cadeauxMois = (int) VisiteCadeau::query()
            ->whereHas('visite', fn ($query) => $query->where('created_at', '>=', $from))
            ->sum('qty');

        $bas = Cadeau::query()->where('active', true)->whereColumn('stock', '<=', 'seuil_alerte')->orderBy('stock')->get();
        $stockNames = $bas->pluck('name')->take(2)->join(', ');
        if ($bas->count() > 2) {
            $stockNames .= ' +'.($bas->count() - 2);
        }

        return [
            Stat::make('Visites du jour', (string) $todayCount)
                ->description($delta === 0 ? 'Identique à hier' : ($delta > 0 ? '+'.$delta.' vs hier' : $delta.' vs hier'))
                ->descriptionIcon($delta >= 0 ? Heroicon::OutlinedArrowTrendingUp : Heroicon::OutlinedArrowTrendingDown, IconPosition::Before)
                ->descriptionColor($delta > 0 ? 'success' : ($delta < 0 ? 'danger' : 'gray'))
                ->icon(Heroicon::OutlinedCalendarDays)
                ->color('primary')
                ->extraAttributes(['class' => 'danino-stat danino-stat-navy']),
            Stat::make('Visites du mois', (string) Visite::query()->where('created_at', '>=', $from)->count())
                ->description('7 derniers jours')
                ->chart($last7)
                ->chartColor('primary')
                ->icon(Heroicon::OutlinedChartBar)
                ->color('primary')
                ->extraAttributes(['class' => 'danino-stat danino-stat-navy']),
            Stat::make('Cadeaux remis', (string) $cadeauxMois)
                ->description('Depuis le '.$from->format('d/m'))
                ->icon(Heroicon::OutlinedGift)
                ->color('danger')
                ->extraAttributes(['class' => 'danino-stat danino-stat-red']),
            Stat::make('Médecins actifs', (string) Medecin::query()->where('active', true)->count())
                ->description('Annuaire')
                ->icon(Heroicon::OutlinedUsers)
                ->color('success')
                ->extraAttributes(['class' => 'danino-stat danino-stat-teal']),
            Stat::make('Délégués', (string) User::query()->where('role', 'delegue')->where('active', true)->count())
                ->description('Comptes actifs')
                ->icon(Heroicon::OutlinedUserGroup)
                ->color('primary')
                ->extraAttributes(['class' => 'danino-stat danino-stat-navy']),
            Stat::make('Stocks bas', (string) $bas->count())
                ->description($bas->isEmpty() ? 'Aucun seuil atteint' : $stockNames)
                ->icon(Heroicon::OutlinedExclamationTriangle)
                ->color($bas->isEmpty() ? 'success' : 'warning')
                ->extraAttributes(['class' => 'danino-stat '.($bas->isEmpty() ? 'danino-stat-teal' : 'danino-stat-amber')]),
        ];
    }
}
