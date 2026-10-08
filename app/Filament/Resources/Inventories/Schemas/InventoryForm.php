<?php

namespace App\Filament\Resources\Inventories\Schemas;

use App\Models\Location;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class InventoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                DatePicker::make('tanggal_inventarisasi')
                    ->label('Tanggal Inventarisasi')
                    ->default(now())
                    ->required(),

                Select::make('location_id')
                    ->label('Lokasi')
                    ->options(
                        Location::query()
                            ->orderBy('nama_lokasi')
                            ->pluck('nama_lokasi', 'id')
                    )
                    ->searchable()
                    ->preload()
                    ->required(),

                Textarea::make('keterangan')
                    ->label('Keterangan')
                    ->rows(4),
            ]);
    }
}