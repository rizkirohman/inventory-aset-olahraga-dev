<?php

namespace App\Filament\Resources\AssetMutations;

use App\Filament\Resources\AssetMutations\Pages\CreateAssetMutation;
use App\Filament\Resources\AssetMutations\Pages\ListAssetMutations;
use App\Filament\Resources\AssetMutations\Pages\ViewAssetMutation;
use App\Filament\Resources\AssetMutations\Schemas\AssetMutationForm;
use App\Filament\Resources\AssetMutations\Schemas\AssetMutationInfolist;
use App\Filament\Resources\AssetMutations\Tables\AssetMutationsTable;
use App\Models\AssetMutation;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class AssetMutationResource extends Resource
{
    protected static ?string $model = AssetMutation::class;

    // Menentukan nama grup navigasi di sidebar
    protected static \UnitEnum|string|null $navigationGroup = 'Manajemen Aset';

    // Urutan ke-3
    protected static ?int $navigationSort = 3;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedArrowsRightLeft;

    protected static ?string $navigationLabel = 'Mutasi Aset';

    protected static ?string $modelLabel = 'Mutasi Aset';

    protected static ?string $pluralModelLabel = 'Mutasi Aset';

    public static function form(Schema $schema): Schema
    {
        return AssetMutationForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return AssetMutationInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return AssetMutationsTable::configure($table);
    }

    public static function canAccess(): bool
    {
        return auth()->user()?->isAdmin()
            || auth()->user()?->isPetugas();
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
            'index' => ListAssetMutations::route('/'),
            'create' => CreateAssetMutation::route('/create'),
            'view' => ViewAssetMutation::route('/{record}'),
        ];
    }
}