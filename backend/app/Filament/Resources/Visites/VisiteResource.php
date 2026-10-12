<?php

namespace App\Filament\Resources\Visites;

use App\Filament\Resources\Visites\Pages\ListVisites;
use App\Filament\Resources\Visites\Pages\ViewVisite;
use App\Models\Visite;
use App\Support\Catalog;
use BackedEnum;
use UnitEnum;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\DatePicker;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ViewEntry;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Enums\FontWeight;
use Filament\Support\Enums\TextSize;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class VisiteResource extends Resource
{
    protected static ?string $model = Visite::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedClipboardDocumentList;

    protected static ?string $navigationLabel = 'Visites';

    protected static ?string $modelLabel = 'visite';

    protected static ?string $pluralModelLabel = 'visites';

    protected static string|UnitEnum|null $navigationGroup = 'Tournée';

    protected static ?int $navigationSort = 2;

    public static function infolist(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Section::make('Visite')
                    ->icon(Heroicon::OutlinedClipboardDocumentList)
                    ->columns(['default' => 1, 'md' => 2, 'xl' => 4])
                    ->schema([
                        TextEntry::make('medecin.fullname')
                            ->label('Médecin')
                            ->size(TextSize::Large)
                            ->weight(FontWeight::SemiBold)
                            ->columnSpan(['default' => 1, 'xl' => 2]),
                        TextEntry::make('delegue.name')->label('Délégué')->placeholder('—'),
                        TextEntry::make('created_at')->label('Date')->dateTime('d/m/Y H:i'),
                        TextEntry::make('nvisite')->label('N° visite')->badge(),
                        TextEntry::make('classe')->badge()->placeholder('—'),
                        TextEntry::make('region')->label('Région')->placeholder('—'),
                        TextEntry::make('municipalite')->label('Municipalité')->placeholder('—'),
                    ]),
                Grid::make(['default' => 1, 'xl' => 3])->schema([
                    Section::make('Lieu')
                        ->icon(Heroicon::OutlinedBuildingOffice2)
                        ->columns(2)
                        ->schema([
                            TextEntry::make('etab')
                                ->label('Type')
                                ->formatStateUsing(fn ($state) => $state ? (Catalog::ETABS[(int) $state] ?? $state) : '—')
                                ->placeholder('—'),
                            TextEntry::make('name_etab')->label('Établissement')->placeholder('—'),
                            TextEntry::make('remarque')->placeholder('—')->columnSpanFull(),
                        ]),
                    Section::make('Position')
                        ->icon(Heroicon::OutlinedMapPin)
                        ->columnSpan(['default' => 1, 'xl' => 2])
                        ->schema([
                            ViewEntry::make('gps')
                                ->hiddenLabel()
                                ->view('filament.visite-map'),
                        ]),
                ]),
                Grid::make(['default' => 1, 'xl' => 2])->schema([
                    Section::make('Cadeaux remis')
                        ->icon(Heroicon::OutlinedGift)
                        ->schema([
                            RepeatableEntry::make('lignes')
                                ->hiddenLabel()
                                ->placeholder('Aucun cadeau')
                                ->schema([
                                    ViewEntry::make('cadeau.name')
                                        ->hiddenLabel()
                                        ->view('filament.visite-cadeau'),
                                ]),
                        ]),
                    Section::make('Photos')
                        ->icon(Heroicon::OutlinedPhoto)
                        ->schema([
                            RepeatableEntry::make('photos')
                                ->hiddenLabel()
                                ->placeholder('Aucune photo')
                                ->grid(['default' => 2, 'lg' => 3])
                                ->schema([
                                    ViewEntry::make('path')
                                        ->hiddenLabel()
                                        ->view('filament.visite-photo'),
                                ]),
                        ]),
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('created_at')->label('Date')->dateTime('d/m/Y H:i')->sortable(),
                TextColumn::make('medecin.fullname')->label('Médecin')->searchable(),
                TextColumn::make('delegue.name')->label('Délégué')->searchable(),
                TextColumn::make('nvisite')->label('N°'),
                TextColumn::make('region')->label('Région'),
                TextColumn::make('classe')->badge(),
            ])
            ->filters([
                Filter::make('periode')
                    ->schema([
                        DatePicker::make('from')->label('Du'),
                        DatePicker::make('to')->label('Au'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when($data['from'] ?? null, fn (Builder $q, string $from) => $q->whereDate('created_at', '>=', $from))
                            ->when($data['to'] ?? null, fn (Builder $q, string $to) => $q->whereDate('created_at', '<=', $to));
                    }),
            ])
            ->recordActions([
                ViewAction::make(),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->with(['medecin', 'delegue', 'lignes.cadeau', 'photos']);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListVisites::route('/'),
            'view' => ViewVisite::route('/{record}'),
        ];
    }
}
