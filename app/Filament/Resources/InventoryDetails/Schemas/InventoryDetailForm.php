<?php

namespace App\Filament\Resources\InventoryDetails\Schemas;

use App\Models\Asset;
use App\Models\Condition;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class InventoryDetailForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('inventory_id')
                    ->label('Inventarisasi')
                    ->relationship('inventory', 'id')
                    ->searchable()
                    ->preload()
                    ->required(),

                Select::make('asset_id')
                    ->label('Aset')
                    ->relationship('asset', 'nama_aset')
                    ->searchable()
                    ->preload()
                    ->required(),

                Select::make('condition_id')
                    ->label('Kondisi')
                    ->relationship('condition', 'nama_kondisi')
                    ->searchable()
                    ->preload()
                    ->required(),

                TextInput::make('jumlah_tercatat')
                    ->label('Jumlah Tercatat')
                    ->numeric()
                    ->minValue(0)
                    ->required(),

                TextInput::make('jumlah_ditemukan')
                    ->label('Jumlah Ditemukan')
                    ->numeric()
                    ->minValue(0)
                    ->required(),

                TextInput::make('selisih')
                    ->label('Selisih')
                    ->numeric()
                    ->disabled()
                    ->dehydrated(false),

                Textarea::make('keterangan')
                    ->label('Keterangan')
                    ->rows(4),
            ]);
    }
}