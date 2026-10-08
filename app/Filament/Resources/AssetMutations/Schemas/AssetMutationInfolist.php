<?php

namespace App\Filament\Resources\AssetMutations\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class AssetMutationInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Mutasi Aset')
                    ->schema([
                        TextEntry::make('asset.kode_aset')
                            ->label('Kode Aset'),

                        TextEntry::make('asset.nama_aset')
                            ->label('Nama Aset'),

                        TextEntry::make('condition.nama_kondisi')
                            ->label('Kondisi'),

                        TextEntry::make('jumlah')
                            ->label('Jumlah yang Dipindahkan')
                            ->suffix(' Unit'),

                        TextEntry::make('lokasiAsal.nama_lokasi')
                            ->label('Lokasi Asal'),

                        TextEntry::make('lokasiTujuan.nama_lokasi')
                            ->label('Lokasi Tujuan'),

                        TextEntry::make('tanggal_mutasi')
                            ->label('Tanggal Mutasi')
                            ->date('d F Y'),

                        TextEntry::make('alasan')
                            ->label('Alasan'),

                        TextEntry::make('keterangan')
                            ->label('Keterangan')
                            ->placeholder('-')
                            ->columnSpanFull(),
                    ])
                    ->columns(2),
            ]);
    }
}