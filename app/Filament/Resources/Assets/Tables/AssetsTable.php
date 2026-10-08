<?php

namespace App\Filament\Resources\Assets\Tables;

use App\Models\Category;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class AssetsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('foto')
                    ->label('Foto')
                    ->disk('public')
                    ->square(),

                TextColumn::make('kode_aset')
                    ->label('Kode Aset')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('nama_aset')
                    ->label('Nama Aset')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('category.nama_kategori')
                    ->label('Kategori')
                    ->sortable(),

                TextColumn::make('jumlah')
                    ->label('Jumlah Perolehan')
                    ->numeric()
                    ->sortable(),

                TextColumn::make('satuan')
                    ->label('Satuan'),

                TextColumn::make('harga_perolehan')
                    ->label('Harga Perolehan')
                    ->money('IDR')
                    ->sortable(),

                TextColumn::make('tahun_perolehan')
                    ->label('Tahun')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('category_id')
                    ->label('Kategori')
                    ->options(Category::pluck('nama_kategori', 'id')),
            ])
            ->recordActions([
                ViewAction::make(),

                EditAction::make(),

                DeleteAction::make()
                    ->visible(
                        fn ($record): bool =>
                            auth()->user()?->isAdmin()
                            && $record->canBeDeleted()
                    ),
            ])
            ->toolbarActions([
                BulkActionGroup::make([]),
            ]);
    }
}