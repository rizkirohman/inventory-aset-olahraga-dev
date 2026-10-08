<?php

namespace App\Filament\Resources\Inventories\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class InventoryInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Inventarisasi')
                    ->schema([
                        TextEntry::make('tanggal_inventarisasi')
                            ->label('Tanggal Inventarisasi')
                            ->date('d F Y'),

                        TextEntry::make('location.nama_lokasi')
                            ->label('Lokasi'),

                        TextEntry::make('keterangan')
                            ->label('Keterangan')
                            ->columnSpanFull(),
                    ])
                    ->columns(2),
            ]);
    }
}