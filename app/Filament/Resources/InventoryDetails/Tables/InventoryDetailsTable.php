<?php

namespace App\Filament\Resources\InventoryDetails\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class InventoryDetailsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('inventory.tanggal_inventarisasi')
                    ->label('Tanggal Inventarisasi')
                    ->date('d F Y')
                    ->sortable(),

                TextColumn::make('inventory.location.nama_lokasi')
                    ->label('Lokasi')
                    ->searchable()
                    ->sortable(),

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

                TextColumn::make('keterangan')
                    ->label('Keterangan')
                    ->limit(50),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}