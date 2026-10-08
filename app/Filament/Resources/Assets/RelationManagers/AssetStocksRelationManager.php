<?php

namespace App\Filament\Resources\Assets\RelationManagers;

use App\Models\Condition;
use App\Models\Location;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class AssetStocksRelationManager extends RelationManager
{
    protected static string $relationship = 'assetStocks';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
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

                Select::make('condition_id')
                    ->label('Kondisi')
                    ->options(
                        Condition::query()
                            ->orderBy('nama_kondisi')
                            ->pluck('nama_kondisi', 'id')
                    )
                    ->searchable()
                    ->preload()
                    ->required(),

                TextInput::make('jumlah')
                    ->label('Jumlah')
                    ->numeric()
                    ->minValue(1)
                    ->required()
                    ->helperText(function (): string {
                        $asset = $this->getOwnerRecord();

                        $totalStok = $asset->assetStocks()->sum('jumlah');
                        $sisa = max(0, $asset->jumlah - $totalStok);

                        return "Stok yang sudah didistribusikan: {$totalStok} {$asset->satuan}. Sisa: {$sisa} {$asset->satuan}.";
                    }),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('id')
            ->columns([
                TextColumn::make('location.nama_lokasi')
                    ->label('Lokasi')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('condition.nama_kondisi')
                    ->label('Kondisi')
                    ->sortable(),

                TextColumn::make('jumlah')
                    ->label('Jumlah')
                    ->numeric()
                    ->sortable(),
            ])
            ->headerActions([
                CreateAction::make()
                    ->label('Tambah Distribusi')
                    ->visible(fn (): bool => ! $this->getOwnerRecord()->hasFinalInventory()),
            ])
            ->recordActions([
                EditAction::make()
                    ->visible(fn (): bool => ! $this->getOwnerRecord()->hasFinalInventory()),

                DeleteAction::make()
                    ->visible(fn (): bool => ! $this->getOwnerRecord()->hasFinalInventory()),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->visible(fn (): bool => ! $this->getOwnerRecord()->hasFinalInventory()),
                ]),
            ]);
    }
}