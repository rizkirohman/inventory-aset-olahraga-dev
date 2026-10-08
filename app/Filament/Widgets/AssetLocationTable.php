<?php

namespace App\Filament\Widgets;

use App\Models\Location;
use Filament\Tables\Columns\Summarizers\Sum;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;

class AssetLocationTable extends TableWidget
{
    protected static ?int $sort = 2;

    protected static ?string $heading = 'Stok Aset Berdasarkan Lokasi';

    protected int|string|array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Location::query()
                    ->withSum('assetStocks', 'jumlah')
                    ->orderBy('nama_lokasi')
            )
            ->columns([
                TextColumn::make('nama_lokasi')
                    ->label('Lokasi')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('asset_stocks_sum_jumlah')
                    ->label('Stok Aktual')
                    ->state(fn (Location $record): int => (int) ($record->asset_stocks_sum_jumlah ?? 0))
                    ->numeric()
                    ->sortable()
                    ->summarize(
                        Sum::make()
                            ->label('Total Stok Aktual')
                    ),
                            ])
                            ->paginated(false);
    }
}