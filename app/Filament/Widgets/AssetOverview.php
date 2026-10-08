<?php

namespace App\Filament\Widgets;

use App\Models\Asset;
use App\Models\AssetStock;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class AssetOverview extends StatsOverviewWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $totalJenisAset = Asset::count();

        $totalPerolehan = Asset::sum('jumlah');

        $totalStokAktual = AssetStock::sum('jumlah');

        $lokasiAktif = AssetStock::query()
            ->distinct('location_id')
            ->count('location_id');

        return [
            Stat::make('Total Jenis Aset', $totalJenisAset)
                ->description('Jenis aset terdaftar')
                ->icon('heroicon-o-archive-box')
                ->color('black')
                ->extraAttributes([
                    'style' => 'border-left: 4px solid #3b82f6 !important;', // Warna Biru
                ]),

            Stat::make('Total Perolehan', number_format($totalPerolehan))
                ->description('Jumlah unit perolehan awal')
                ->icon('heroicon-o-cube')
                ->color('black')
                ->extraAttributes([
                    'style' => 'border-left: 4px solid #f43f5e !important;', // Warna Merah/Rose
                ]),

            Stat::make('Total Stok Aktual', number_format($totalStokAktual))
                ->description('Jumlah unit stok saat ini')
                ->icon('heroicon-o-clipboard-document-list')
                ->color('black')
                ->extraAttributes([
                    'style' => 'border-left: 4px solid #10b981 !important;', // Warna Hijau/Emerald
                ]),

            Stat::make('Lokasi Aktif', $lokasiAktif)
                ->description('Lokasi yang memiliki stok')
                ->icon('heroicon-o-map-pin')
                ->color('black')
                ->extraAttributes([
                    'style' => 'border-left: 4px solid #f59e0b !important;', // Warna Amber/Oranye
                ]),
        ];
    }
}