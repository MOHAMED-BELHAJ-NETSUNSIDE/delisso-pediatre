<?php

namespace App\Filament\Resources\Medecins;

use App\Filament\Resources\Medecins\Pages\CreateMedecin;
use App\Filament\Resources\Medecins\Pages\EditMedecin;
use App\Filament\Resources\Medecins\Pages\ListMedecins;
use App\Models\Medecin;
use App\Support\Catalog;
use BackedEnum;
use UnitEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class MedecinResource extends Resource
{
    protected static ?string $model = Medecin::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUserGroup;

    protected static ?string $navigationLabel = 'Médecins';

    protected static ?string $modelLabel = 'médecin';

    protected static ?string $pluralModelLabel = 'médecins';

    protected static string|UnitEnum|null $navigationGroup = 'Tournée';

    protected static ?int $navigationSort = 1;

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Grid::make(2)->schema([
                TextInput::make('fullname')->label('Nom complet')->required()->maxLength(190),
                Select::make('type')->label('Type')->options(Catalog::TYPES)->default(1)->required(),
                TextInput::make('region')->maxLength(120),
                TextInput::make('municipalite')->label('Municipalité')->maxLength(120),
                Select::make('etab')->label('Type établissement')->options(Catalog::ETABS)->placeholder('—'),
                TextInput::make('name_etab')->label('Nom établissement')->maxLength(190),
                TextInput::make('adresse')->maxLength(255)->columnSpanFull(),
                TextInput::make('tel')->label('Téléphone')->maxLength(60),
                TextInput::make('email')->email()->maxLength(190),
                Select::make('classe')->options(Catalog::CLASSES)->placeholder('—'),
                Toggle::make('active')->label('Actif')->default(true),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('fullname')->label('Nom')->searchable()->sortable(),
                TextColumn::make('type')->formatStateUsing(fn ($state) => Catalog::TYPES[(int) $state] ?? $state),
                TextColumn::make('region')->searchable(),
                TextColumn::make('municipalite')->label('Municipalité'),
                TextColumn::make('classe')->badge(),
                IconColumn::make('active')->label('Actif')->boolean(),
            ])
            ->filters([
                TernaryFilter::make('active')->label('Actif'),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('fullname');
    }

    public static function getPages(): array
    {
        return [
            'index' => ListMedecins::route('/'),
            'create' => CreateMedecin::route('/create'),
            'edit' => EditMedecin::route('/{record}/edit'),
        ];
    }
}
