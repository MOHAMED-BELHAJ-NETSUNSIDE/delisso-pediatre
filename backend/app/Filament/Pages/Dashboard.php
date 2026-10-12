<?php

namespace App\Filament\Pages;

use App\Models\Cadeau;
use App\Models\Visite;
use App\Models\VisiteCadeau;
use App\Support\Catalog;
use Filament\Pages\Dashboard as BaseDashboard;
use Filament\Support\Icons\Heroicon;
use Illuminate\Contracts\View\View;

class Dashboard extends BaseDashboard
{
    protected static bool $isDiscovered = false;

    protected static ?string $navigationLabel = 'Tableau de bord';

    protected static ?string $title = 'Tableau de bord';

    protected static string|\BackedEnum|null $navigationIcon = Heroicon::OutlinedHome;

    public function getColumns(): int|array
    {
        return [
            'md' => 2,
        ];
    }

    /**
     * @return array<string>
     */
    public function getPageClasses(): array
    {
        return ['danino-dashboard'];
    }

    public function getHeader(): ?View
    {
        $user = auth()->user();
        $name = trim((string) ($user?->name ?? ''));
        $first = $name !== '' ? explode(' ', $name, 2)[0] : null;
        $from = now()->startOfMonth();

        $low = Cadeau::query()
            ->where('active', true)
            ->whereColumn('stock', '<=', 'seuil_alerte')
            ->count();

        return view('filament.dashboard-header', [
            'greeting' => $first ? 'Bonjour, '.$first : 'Bonjour',
            'role' => Catalog::ROLES[$user?->role ?? ''] ?? 'Équipe',
            'date' => ucfirst(now()->locale('fr')->translatedFormat('l j F Y')),
            'metrics' => [
                [
                    'label' => 'Aujourd’hui',
                    'value' => Visite::query()->whereDate('created_at', today())->count(),
                    'hint' => 'visites',
                    'alert' => false,
                ],
                [
                    'label' => 'Ce mois',
                    'value' => Visite::query()->where('created_at', '>=', $from)->count(),
                    'hint' => 'visites',
                    'alert' => false,
                ],
                [
                    'label' => 'Cadeaux',
                    'value' => (int) VisiteCadeau::query()
                        ->whereHas('visite', fn ($query) => $query->where('created_at', '>=', $from))
                        ->sum('qty'),
                    'hint' => 'remis',
                    'alert' => false,
                ],
                [
                    'label' => 'Stocks bas',
                    'value' => $low,
                    'hint' => $low === 1 ? 'alerte' : 'alertes',
                    'alert' => $low > 0,
                ],
            ],
        ]);
    }
}
