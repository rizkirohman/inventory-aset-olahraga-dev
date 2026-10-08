<?php

namespace App\Filament\Resources\InventoryDetails;

use App\Filament\Resources\InventoryDetails\Pages\CreateInventoryDetail;
use App\Filament\Resources\InventoryDetails\Pages\EditInventoryDetail;
use App\Filament\Resources\InventoryDetails\Pages\ListInventoryDetails;
use App\Filament\Resources\InventoryDetails\Schemas\InventoryDetailForm;
use App\Filament\Resources\InventoryDetails\Tables\InventoryDetailsTable;
use App\Models\InventoryDetail;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class InventoryDetailResource extends Resource
{
    protected static ?string $model = InventoryDetail::class;

    protected static bool $shouldRegisterNavigation = false;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return InventoryDetailForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return InventoryDetailsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListInventoryDetails::route('/'),
            'create' => CreateInventoryDetail::route('/create'),
            'edit' => EditInventoryDetail::route('/{record}/edit'),
        ];
    }
}
