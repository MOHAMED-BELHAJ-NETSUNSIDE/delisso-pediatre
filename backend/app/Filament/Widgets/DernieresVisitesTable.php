<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\Visites\VisiteResource;
use App\Models\Visite;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;

class DernieresVisitesTable extends TableWidget
{
    protected static ?int $sort = 5;

    protected static bool $isLazy = false;

    protected int|string|array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->heading('Dernières visites')
            ->query(Visite::query()->with(['medecin', 'delegue'])->latest())
            ->columns([
                TextColumn::make('created_at')->label('Date')->dateTime('d/m/Y H:i'),
                TextColumn::make('medecin.fullname')->label('Médecin'),
                TextColumn::make('delegue.name')->label('Délégué'),
                TextColumn::make('region')->label('Région'),
                TextColumn::make('classe')->label('Classe')->badge(),
                TextColumn::make('nvisite')->label('N°'),
            ])
            ->recordUrl(fn (Visite $record): string => VisiteResource::getUrl('view', ['record' => $record]))
            ->paginated([5])
            ->defaultPaginationPageOption(5);
    }
}
