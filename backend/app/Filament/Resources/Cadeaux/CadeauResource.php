<?php

namespace App\Filament\Resources\Cadeaux;

use App\Filament\Resources\Cadeaux\Pages\CreateCadeau;
use App\Filament\Resources\Cadeaux\Pages\EditCadeau;
use App\Filament\Resources\Cadeaux\Pages\ListCadeaux;
use App\Models\Cadeau;
use App\Services\StockService;
use BackedEnum;
use UnitEnum;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Schema;
use Filament\Support\Exceptions\Halt;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Throwable;

class CadeauResource extends Resource
{
    protected static ?string $model = Cadeau::class;

    protected static ?string $slug = 'cadeaux';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedGift;

    protected static ?string $navigationLabel = 'Cadeaux';

    protected static ?string $modelLabel = 'cadeau';

    protected static ?string $pluralModelLabel = 'cadeaux';

    protected static string|UnitEnum|null $navigationGroup = 'Catalogue';

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Grid::make(2)->schema([
                TextInput::make('name')->label('Nom')->required()->maxLength(190),
                TextInput::make('seuil_alerte')->label('Seuil d’alerte')->numeric()->default(10)->required()->minValue(0),
                TextInput::make('stock')
                    ->numeric()
                    ->default(0)
                    ->minValue(0)
                    ->required(fn (string $operation): bool => $operation === 'create')
                    ->disabled(fn (string $operation): bool => $operation === 'edit')
                    ->dehydrated(fn (string $operation): bool => $operation === 'create'),
                Toggle::make('active')->label('Actif')->default(true),
                FileUpload::make('image_path')
                    ->label('Image')
                    ->image()
                    ->disk('public')
                    ->directory('cadeaux')
                    ->columnSpanFull(),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image_path')->label('Image')->disk('public'),
                TextColumn::make('name')->label('Nom')->searchable()->sortable(),
                TextColumn::make('stock')
                    ->badge()
                    ->color(fn (Cadeau $record): string => $record->stock <= $record->seuil_alerte ? 'warning' : 'success'),
                TextColumn::make('seuil_alerte')->label('Seuil'),
                IconColumn::make('active')->label('Actif')->boolean(),
            ])
            ->recordActions([
                EditAction::make(),
                Action::make('stock')
                    ->label('Stock')
                    ->icon(Heroicon::OutlinedArchiveBox)
                    ->schema([
                        Select::make('type')
                            ->options([
                                'in' => 'Entrée',
                                'out' => 'Sortie',
                                'adjust' => 'Ajuster à',
                            ])
                            ->required(),
                        TextInput::make('qty')->label('Quantité')->numeric()->required()->minValue(0),
                        TextInput::make('note')->maxLength(255),
                    ])
                    ->action(function (Cadeau $record, array $data): void {
                        try {
                            app(StockService::class)->adjust(
                                $record,
                                $data['type'],
                                (int) $data['qty'],
                                auth()->id(),
                                $data['note'] ?: null,
                            );
                        } catch (Throwable $e) {
                            Notification::make()->title($e->getMessage())->danger()->send();
                            throw new Halt;
                        }

                        Notification::make()->title('Stock mis à jour')->success()->send();
                    }),
            ])
            ->defaultSort('name');
    }

    public static function getPages(): array
    {
        return [
            'index' => ListCadeaux::route('/'),
            'create' => CreateCadeau::route('/create'),
            'edit' => EditCadeau::route('/{record}/edit'),
        ];
    }
}
