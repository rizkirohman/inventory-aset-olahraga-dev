<?php

namespace App\Filament\Resources\InventoryDetails\Pages;

use App\Filament\Resources\InventoryDetails\InventoryDetailResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditInventoryDetail extends EditRecord
{
    protected static string $resource = InventoryDetailResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
