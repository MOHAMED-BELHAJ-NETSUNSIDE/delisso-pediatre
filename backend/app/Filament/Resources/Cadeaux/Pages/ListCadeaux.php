<?php

namespace App\Filament\Resources\Cadeaux\Pages;

use App\Filament\Resources\Cadeaux\CadeauResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListCadeaux extends ListRecords
{
    protected static string $resource = CadeauResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
