<?php

namespace App\Filament\Resources\Inventories\RelationManagers;

use App\Models\Asset;
use App\Models\AssetStock;
use App\Models\Condition;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class InventoryDetailsRelationManager extends RelationManager
{
    protected static string $relationship = 'inventoryDetails';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('asset_id')
                    ->label('Aset')
                    ->options(function (): array {
                        $locationId = $this->getOwnerRecord()->location_id;

                        return Asset::query()
                            ->whereHas('assetStocks', function ($query) use ($locationId) {
                                $query
                                    ->where('location_id', $locationId)
                                    ->where('jumlah', '>', 0);
                            })
                            ->orderBy('nama_aset')
                            ->pluck('nama_aset', 'id')
                            ->toArray();
                    })
                    ->searchable()
                    ->preload()
                    ->live()
                    ->afterStateUpdated(function (Set $set): void {
                        $set('condition_id', null);
                        $set('jumlah_tercatat', null);
                        $set('jumlah_ditemukan', null);
                        $set('selisih', null);
                    })
                    ->required(),

                Select::make('condition_id')
                    ->label('Kondisi')
                    ->options(function (Get $get): array {
                        $assetId = $get('asset_id');
                        $locationId = $this->getOwnerRecord()->location_id;

                        if (! $assetId) {
                            return [];
                        }

                        return Condition::query()
                            ->whereHas('assetStocks', function ($query) use ($assetId, $locationId) {
                                $query
                                    ->where('asset_id', $assetId)
                                    ->where('location_id', $locationId)
                                    ->where('jumlah', '>', 0);
                            })
                            ->orderBy('nama_kondisi')
                            ->pluck('nama_kondisi', 'id')
                            ->toArray();
                    })
                    ->searchable()
                    ->preload()
                    ->live()
                    ->afterStateUpdated(function (Get $get, Set $set): void {
                        $assetId = $get('asset_id');
                        $conditionId = $get('condition_id');
                        $locationId = $this->getOwnerRecord()->location_id;

                        $set('jumlah_ditemukan', null);
                        $set('selisih', null);

                        if (! $assetId || ! $conditionId) {
                            $set('jumlah_tercatat', null);

                            return;
                        }

                        $stock = AssetStock::query()
                            ->where('asset_id', $assetId)
                            ->where('location_id', $locationId)
                            ->where('condition_id', $conditionId)
                            ->first();

                        $set('jumlah_tercatat', $stock?->jumlah ?? 0);
                    })
                    ->required(),

                TextInput::make('jumlah_tercatat')
                    ->label('Jumlah Tercatat')
                    ->numeric()
                    ->disabled()
                    ->dehydrated()
                    ->helperText('Jumlah stok berdasarkan data sistem.'),

                TextInput::make('jumlah_ditemukan')
                    ->label('Jumlah Ditemukan')
                    ->numeric()
                    ->minValue(0)
                    ->required()
                    ->live()
                    ->afterStateUpdated(function (Get $get, Set $set, $state): void {
                        $jumlahTercatat = (int) ($get('jumlah_tercatat') ?? 0);
                        $jumlahDitemukan = (int) ($state ?? 0);

                        $set(
                            'selisih',
                            $jumlahDitemukan - $jumlahTercatat
                        );
                    })
                    ->helperText('Masukkan jumlah aset yang ditemukan secara fisik.'),

                TextInput::make('selisih')
                    ->label('Selisih')
                    ->numeric()
                    ->disabled()
                    ->dehydrated()
                    ->helperText('Jumlah ditemukan dikurangi jumlah tercatat.'),

                Textarea::make('keterangan')
                    ->label('Keterangan')
                    ->rows(3),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('asset.nama_aset')
            ->columns([
                TextColumn::make('asset.kode_aset')
                    ->label('Kode Aset')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('asset.nama_aset')
                    ->label('Aset')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('condition.nama_kondisi')
                    ->label('Kondisi')
                    ->sortable(),

                TextColumn::make('jumlah_tercatat')
                    ->label('Tercatat')
                    ->numeric()
                    ->sortable(),

                TextColumn::make('jumlah_ditemukan')
                    ->label('Ditemukan')
                    ->numeric()
                    ->sortable(),

                TextColumn::make('selisih')
                    ->label('Selisih')
                    ->numeric()
                    ->sortable(),
            ])
            ->headerActions([
                CreateAction::make()
                    ->label('Tambah Detail')
                    ->visible(
                        fn (): bool => $this->getOwnerRecord()->status === 'draft'
                    ),
            ])
            ->recordActions([
                EditAction::make()
                    ->visible(
                        fn (): bool => $this->getOwnerRecord()->status === 'draft'
                    ),

                DeleteAction::make()
                    ->visible(
                        fn (): bool => $this->getOwnerRecord()->status === 'draft'
                    ),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->visible(
                            fn (): bool => $this->getOwnerRecord()->status === 'draft'
                        ),
                ]),
            ]);
    }
}