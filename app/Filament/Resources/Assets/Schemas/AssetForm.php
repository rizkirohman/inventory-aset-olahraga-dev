<?php

namespace App\Filament\Resources\Assets\Schemas;

use App\Models\Category;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class AssetForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('kode_aset')
                    ->label('Kode Aset')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(255),

                TextInput::make('nama_aset')
                    ->label('Nama Aset')
                    ->required()
                    ->maxLength(255),

                Select::make('category_id')
                    ->label('Kategori')
                    ->options(Category::pluck('nama_kategori', 'id'))
                    ->searchable()
                    ->preload()
                    ->required(),

                TextInput::make('merek')
                    ->label('Merek')
                    ->maxLength(255),

                TextInput::make('tipe')
                    ->label('Tipe')
                    ->maxLength(255),

                TextInput::make('nomor_seri')
                    ->label('Nomor Seri')
                    ->maxLength(255),

                TextInput::make('tahun_perolehan')
                    ->label('Tahun Perolehan')
                    ->numeric()
                    ->minValue(1900)
                    ->maxValue((int) date('Y')),

                // 1. Penyesuaian Harga Perolehan (Satuan)
                TextInput::make('harga_perolehan')
                    ->label('Harga Perolehan (Satuan)')
                    ->helperText('Masukkan harga beli per unit barang')
                    ->numeric()
                    ->prefix('Rp')
                    ->live(onBlur: true), // Live update saat berpindah input

                TextInput::make('sumber_dana')
                    ->label('Sumber Dana')
                    ->maxLength(255),

                TextInput::make('jumlah')
                    ->label('Jumlah Total')
                    ->numeric()
                    ->minValue(1)
                    ->default(1)
                    ->required()
                    ->live(onBlur: true), // Live update saat jumlah diubah

                // 2. (Opsional) Field Kalkulasi Total Nilai Aset
                // TextInput::make('total_nilai_aset')
                //     ->label('Total Nilai Aset')
                //     ->helperText('Total = Harga Satuan x Jumlah')
                //     ->prefix('Rp')
                //     ->disabled()
                //     ->dehydrated(false)
                //     ->placeholder(function ($get) { // Hapus type-hint 'Get' di sini
                //         $harga = (float) $get('harga_perolehan');
                //         $jumlah = (int) $get('jumlah');
                        
                //         return number_format($harga * $jumlah, 0, ',', '.');
                //     }),

                TextInput::make('satuan')
                    ->label('Satuan')
                    ->default('Unit')
                    ->required()
                    ->maxLength(50),

                FileUpload::make('foto')
                    ->label('Foto Aset')
                    ->image()
                    ->disk('public')
                    ->directory('assets')
                    ->imageEditor()
                    ->maxSize(2048),

                Textarea::make('keterangan')
                    ->label('Keterangan')
                    ->rows(4),
            ]);
    }
}