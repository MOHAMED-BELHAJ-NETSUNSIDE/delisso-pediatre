<?php

namespace App\Filament\Resources\Cadeaux\Pages;

use App\Filament\Resources\Cadeaux\CadeauResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditCadeau extends EditRecord
{
    protected static string $resource = CadeauResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
