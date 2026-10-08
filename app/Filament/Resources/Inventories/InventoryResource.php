<?php

namespace App\Filament\Resources\Inventories;

use App\Filament\Resources\Inventories\Pages\CreateInventory;
use App\Filament\Resources\Inventories\Pages\EditInventory;
use App\Filament\Resources\Inventories\Pages\ListInventories;
use App\Filament\Resources\Inventories\Pages\ViewInventory;
use App\Filament\Resources\Inventories\RelationManagers\InventoryDetailsRelationManager;
use App\Filament\Resources\Inventories\Schemas\InventoryForm;
use App\Filament\Resources\Inventories\Schemas\InventoryInfolist;
use App\Filament\Resources\Inventories\Tables\InventoriesTable;
use App\Models\Inventory;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use UnitEnum;

class InventoryResource extends Resource
{
    protected static ?string $model = Inventory::class;

    // Menentukan nama grup navigasi di sidebar
    protected static \UnitEnum|string|null $navigationGroup = 'Manajemen Aset';

    // Urutan ke-2
    protected static ?int $navigationSort = 4;

    protected static ?string $navigationLabel = 'Inventarisasi';

    protected static ?string $modelLabel = 'Inventarisasi';

    protected static ?string $pluralModelLabel = 'Inventarisasi';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return InventoryForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return InventoryInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return InventoriesTable::configure($table);
    }

    public static function canAccess(): bool
    {
        return auth()->user()?->isAdmin()
            || auth()->user()?->isPetugas();
    }

    public static function canEdit(Model $record): bool
    {
        return $record->status === 'draft';
    }

    public static function canDelete(Model $record): bool
    {
        return auth()->user()?->isAdmin()
            && $record->status === 'draft';
    }

    public static function getRelations(): array
    {
        return [
            InventoryDetailsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListInventories::route('/'),
            'create' => CreateInventory::route('/create'),
            'view' => ViewInventory::route('/{record}'),
            'edit' => EditInventory::route('/{record}/edit'),
        ];
    }
}