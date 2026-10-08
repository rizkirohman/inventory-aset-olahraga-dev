<?php

namespace App\Filament\Resources\InventoryDetails\Pages;

use App\Filament\Resources\InventoryDetails\InventoryDetailResource;
use Filament\Resources\Pages\CreateRecord;

class CreateInventoryDetail extends CreateRecord
{
    protected static string $resource = InventoryDetailResource::class;
}
