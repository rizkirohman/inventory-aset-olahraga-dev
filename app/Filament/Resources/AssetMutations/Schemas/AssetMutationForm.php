<?php

namespace App\Filament\Resources\AssetMutations\Schemas;

use App\Models\Asset;
use App\Models\AssetStock;
use App\Models\Condition;
use App\Models\Location;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;

class AssetMutationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('asset_id')
                    ->label('Aset')
                    ->options(
                        Asset::query()
                            ->orderBy('nama_aset')
                            ->pluck('nama_aset', 'id')
                    )
                    ->searchable()
                    ->preload()
                    ->live()
                    ->afterStateUpdated(function (Set $set): void {
                        $set('condition_id', null);
                        $set('lokasi_asal_id', null);
                        $set('jumlah', null);
                    })
                    ->required(),

                Select::make('condition_id')
                    ->label('Kondisi')
                    ->options(function (Get $get): array {
                        $assetId = $get('asset_id');

                        if (! $assetId) {
                            return [];
                        }

                        return Condition::query()
                            ->whereHas('assetStocks', function ($query) use ($assetId) {
                                $query->where('asset_id', $assetId)
                                    ->where('jumlah', '>', 0);
                            })
                            ->orderBy('nama_kondisi')
                            ->pluck('nama_kondisi', 'id')
                            ->toArray();
                    })
                    ->searchable()
                    ->preload()
                    ->live()
                    ->afterStateUpdated(function (Set $set): void {
                        $set('lokasi_asal_id', null);
                        $set('jumlah', null);
                    })
                    ->required(),

                Select::make('lokasi_asal_id')
                    ->label('Lokasi Asal')
                    ->options(function (Get $get): array {
                        $assetId = $get('asset_id');
                        $conditionId = $get('condition_id');

                        if (! $assetId || ! $conditionId) {
                            return [];
                        }

                        return Location::query()
                            ->whereHas('assetStocks', function ($query) use ($assetId, $conditionId) {
                                $query->where('asset_id', $assetId)
                                    ->where('condition_id', $conditionId)
                                    ->where('jumlah', '>', 0);
                            })
                            ->orderBy('nama_lokasi')
                            ->pluck('nama_lokasi', 'id')
                            ->toArray();
                    })
                    ->searchable()
                    ->preload()
                    ->live()
                    ->afterStateUpdated(function (Set $set): void {
                        $set('jumlah', null);
                    })
                    ->required(),

                Select::make('lokasi_tujuan_id')
                    ->label('Lokasi Tujuan')
                    ->options(
                        Location::query()
                            ->orderBy('nama_lokasi')
                            ->pluck('nama_lokasi', 'id')
                    )
                    ->searchable()
                    ->preload()
                    ->required()
                    ->rule(function (Get $get) {
                        return function (string $attribute, mixed $value, \Closure $fail) use ($get): void {
                            $lokasiAsalId = $get('lokasi_asal_id');

                            if (! $lokasiAsalId || ! $value) {
                                return;
                            }

                            if ((int) $lokasiAsalId === (int) $value) {
                                $lokasi = Location::find($value);

                                $namaLokasi = $lokasi?->nama_lokasi ?? 'tersebut';

                                $fail(
                                    "Lokasi tujuan tidak boleh sama dengan lokasi asal ({$namaLokasi})."
                                );
                            }
                        };
                    }),

                TextInput::make('jumlah')
                    ->label('Jumlah yang Dipindahkan')
                    ->numeric()
                    ->minValue(1)
                    ->required()
                    ->validationMessages([
                        'min' => 'Jumlah yang dipindahkan minimal 1.',
                    ])
                    ->rule(function (Get $get) {
                        return function (string $attribute, mixed $value, \Closure $fail) use ($get): void {
                            $assetId = $get('asset_id');
                            $conditionId = $get('condition_id');
                            $locationId = $get('lokasi_asal_id');

                            if (! $assetId || ! $conditionId || ! $locationId) {
                                return;
                            }

                            $stock = AssetStock::query()
                                ->where('asset_id', $assetId)
                                ->where('condition_id', $conditionId)
                                ->where('location_id', $locationId)
                                ->first();

                            if (! $stock) {
                                $fail('Stok pada lokasi asal tidak ditemukan.');
                                return;
                            }

                            if ((int) $value > (int) $stock->jumlah) {
                                $fail(
                                    "Jumlah yang dipindahkan ({$value}) melebihi stok tersedia ({$stock->jumlah} {$stock->asset->satuan})."
                                );
                            }
                        };
                    })
                    ->helperText(function (Get $get): string {
                        $assetId = $get('asset_id');
                        $conditionId = $get('condition_id');
                        $locationId = $get('lokasi_asal_id');

                        if (! $assetId || ! $conditionId || ! $locationId) {
                            return 'Pilih aset, kondisi, dan lokasi asal terlebih dahulu.';
                        }

                        $stock = AssetStock::query()
                            ->where('asset_id', $assetId)
                            ->where('condition_id', $conditionId)
                            ->where('location_id', $locationId)
                            ->first();

                        if (! $stock) {
                            return 'Stok tidak ditemukan.';
                        }

                        return "Stok tersedia: {$stock->jumlah} {$stock->asset->satuan}.";
                    }),

                DatePicker::make('tanggal_mutasi')
                    ->label('Tanggal Mutasi')
                    ->default(now())
                    ->required(),

                TextInput::make('alasan')
                    ->label('Alasan')
                    ->maxLength(255),

                Textarea::make('keterangan')
                    ->label('Keterangan')
                    ->rows(4),
            ]);
    }
}