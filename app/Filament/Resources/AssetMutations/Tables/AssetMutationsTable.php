<?php

namespace App\Filament\Resources\AssetMutations\Tables;

use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class AssetMutationsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('asset.kode_aset')
                    ->label('Kode Aset')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('asset.nama_aset')
                    ->label('Nama Aset')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('condition.nama_kondisi')
                    ->label('Kondisi')
                    ->sortable(),

                TextColumn::make('jumlah')
                    ->label('Jumlah')
                    ->numeric()
                    ->sortable(),

                TextColumn::make('lokasiAsal.nama_lokasi')
                    ->label('Lokasi Asal')
                    ->sortable(),

                TextColumn::make('lokasiTujuan.nama_lokasi')
                    ->label('Lokasi Tujuan')
                    ->sortable(),

                TextColumn::make('tanggal_mutasi')
                    ->label('Tanggal Mutasi')
                    ->date('d F Y')
                    ->sortable(),

                TextColumn::make('alasan')
                    ->label('Alasan')
                    ->searchable(),

                TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d F Y H:i')
                    ->sortable(),
            ])
            ->recordActions([
                ViewAction::make(),
            ]);
    }
}