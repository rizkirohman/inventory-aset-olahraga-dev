<?php

namespace App\Filament\Resources\Inventories\Tables;

use App\Models\Location;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class InventoriesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('tanggal_inventarisasi')
                    ->label('Tanggal Inventarisasi')
                    ->date('d F Y')
                    ->sortable(),

                TextColumn::make('location.nama_lokasi')
                    ->label('Lokasi')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'draft' => 'Draft',
                        'final' => 'Final',
                        default => ucfirst($state),
                    })
                    ->sortable(),

                TextColumn::make('keterangan')
                    ->label('Keterangan')
                    ->limit(50),

                TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d F Y H:i')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('location_id')
                    ->label('Lokasi')
                    ->options(
                        Location::query()
                            ->orderBy('nama_lokasi')
                            ->pluck('nama_lokasi', 'id')
                    ),
            ])
            ->recordActions([
                ViewAction::make(),
                
                EditAction::make()
                    ->visible(
                        fn ($record): bool =>
                            $record->status === 'draft'
                    ),

                DeleteAction::make()
                    ->visible(
                        fn ($record): bool =>
                            auth()->user()?->isAdmin()
                            && $record->status === 'draft'
                    ),
            ])
            ->toolbarActions([
                BulkActionGroup::make([]),
            ]);
    }
}