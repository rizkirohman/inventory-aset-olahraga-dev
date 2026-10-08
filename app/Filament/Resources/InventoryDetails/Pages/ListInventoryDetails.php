<?php

namespace App\Filament\Resources\InventoryDetails\Pages;

use App\Filament\Resources\InventoryDetails\InventoryDetailResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListInventoryDetails extends ListRecords
{
    protected static string $resource = InventoryDetailResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
