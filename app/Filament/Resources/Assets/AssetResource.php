<?php

namespace App\Filament\Resources\Assets;

use App\Filament\Resources\Assets\Pages\CreateAsset;
use App\Filament\Resources\Assets\Pages\EditAsset;
use App\Filament\Resources\Assets\Pages\ListAssets;
use App\Filament\Resources\Assets\Pages\ViewAsset;
use App\Filament\Resources\Assets\RelationManagers\AssetStocksRelationManager;
use App\Filament\Resources\Assets\Schemas\AssetForm;
use App\Filament\Resources\Assets\Tables\AssetsTable;
use App\Models\Asset;
use BackedEnum;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class AssetResource extends Resource
{
    protected static ?string $model = Asset::class;

    // Menentukan nama grup navigasi di sidebar
    protected static \UnitEnum|string|null $navigationGroup = 'Manajemen Aset';

    // Urutan ke-1
    protected static ?int $navigationSort = 1;

    // Label navigasi Bahasa Indonesia
    protected static ?string $navigationLabel = 'Aset';
    protected static ?string $modelLabel = 'Aset';
    protected static ?string $pluralModelLabel = 'Aset';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCube;

    public static function form(Schema $schema): Schema
    {
        return AssetForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Aset')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                ImageEntry::make('foto')
                                    ->label('Foto Aset')
                                    ->disk('public')
                                    ->square()
                                    ->extraAttributes([
                                        'class' => 'border-b border-gray-200 dark:border-gray-700 pb-4',
                                    ]),

                                TextEntry::make('kode_aset')
                                    ->label('Kode Aset')
                                    ->extraAttributes([
                                        'class' => 'border-b border-gray-200 dark:border-gray-700 pb-4',
                                    ]),

                                TextEntry::make('nama_aset')
                                    ->label('Nama Aset')
                                    ->extraAttributes([
                                        'class' => 'border-b border-gray-200 dark:border-gray-700 pb-4',
                                    ]),

                                TextEntry::make('category.nama_kategori')
                                    ->label('Kategori')
                                    ->extraAttributes([
                                        'class' => 'border-b border-gray-200 dark:border-gray-700 pb-4',
                                    ]),

                                TextEntry::make('merek')
                                    ->label('Merek')
                                    ->extraAttributes([
                                        'class' => 'border-b border-gray-200 dark:border-gray-700 pb-4',
                                    ]),

                                TextEntry::make('tipe')
                                    ->label('Tipe')
                                    ->extraAttributes([
                                        'class' => 'border-b border-gray-200 dark:border-gray-700 pb-4',
                                    ]),

                                TextEntry::make('nomor_seri')
                                    ->label('Nomor Seri')
                                    ->extraAttributes([
                                        'class' => 'border-b border-gray-200 dark:border-gray-700 pb-4',
                                    ]),

                                TextEntry::make('tahun_perolehan')
                                    ->label('Tahun Perolehan')
                                    ->extraAttributes([
                                        'class' => 'border-b border-gray-200 dark:border-gray-700 pb-4',
                                    ]),

                                TextEntry::make('harga_perolehan')
                                    ->label('Harga Perolehan')
                                    ->money('IDR')
                                    ->extraAttributes([
                                        'class' => 'border-b border-gray-200 dark:border-gray-700 pb-4',
                                    ]),

                                TextEntry::make('sumber_dana')
                                    ->label('Sumber Dana')
                                    ->extraAttributes([
                                        'class' => 'border-b border-gray-200 dark:border-gray-700 pb-4',
                                    ]),

                                TextEntry::make('jumlah')
                                    ->label('Jumlah Total (Perolehan Awal / Sebelum SO)')
                                    ->extraAttributes([
                                        'class' => 'border-b border-gray-200 dark:border-gray-700 pb-4',
                                    ]),

                                TextEntry::make('satuan')
                                    ->label('Satuan')
                                    ->extraAttributes([
                                        'class' => 'border-b border-gray-200 dark:border-gray-700 pb-4',
                                    ]),
                            ]),

                        TextEntry::make('keterangan')
                            ->label('Keterangan')
                            ->placeholder('-')
                            ->columnSpanFull()
                            ->extraAttributes([
                                'class' => 'pt-4',
                            ]),
                    ])
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return AssetsTable::configure($table);
    }

    public static function canAccess(): bool
    {
        return auth()->user()?->isAdmin()
            || auth()->user()?->isPetugas();
    }

    public static function getRelations(): array
    {
        return [
            AssetStocksRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListAssets::route('/'),
            'create' => CreateAsset::route('/create'),
            'view' => ViewAsset::route('/{record}'),
            'edit' => EditAsset::route('/{record}/edit'),
        ];
    }
}