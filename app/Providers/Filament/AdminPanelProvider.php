<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\NavigationGroup;
use Filament\Navigation\NavigationItem;
use Filament\Pages\Dashboard;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Support\Icons\Heroicon;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login()
            ->spa()
            ->colors([
                'primary' => Color::Blue,
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\Filament\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\Filament\Pages')
            ->pages([
                Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\Filament\Widgets')
            ->widgets([])

            // Urutan Grup Navigasi di Sidebar berdasarkan urutan posisi array
            ->navigationGroups([
                NavigationGroup::make('Manajemen Aset'),
                NavigationGroup::make('Data Master'),
                NavigationGroup::make('Laporan'),
                NavigationGroup::make('Manajemen User'),
                NavigationGroup::make('Monitoring'),
            ])

            // Item Navigasi Laporan
            ->navigationItems([
                NavigationItem::make('Laporan Stok')
                    ->url(fn (): string => route('laporan.stok'))
                    ->icon(Heroicon::OutlinedDocumentText)
                    ->group('Laporan')
                    ->sort(1)
                    ->isActiveWhen(fn (): bool => request()->routeIs('laporan.stok')),

                NavigationItem::make('Laporan Mutasi')
                    ->url(fn (): string => route('laporan.mutasi'))
                    ->icon(Heroicon::OutlinedArrowsRightLeft)
                    ->group('Laporan')
                    ->sort(2)
                    ->isActiveWhen(fn (): bool => request()->routeIs('laporan.mutasi')),

                NavigationItem::make('Laporan Inventarisasi')
                    ->url(fn (): string => route('laporan.inventarisasi'))
                    ->icon(Heroicon::OutlinedClipboardDocumentCheck)
                    ->group('Laporan')
                    ->sort(3)
                    ->isActiveWhen(fn (): bool => request()->routeIs('laporan.inventarisasi')),

                NavigationItem::make('Laporan Aktivitas')
                    ->url(fn (): string => route('laporan.aktivitas'))
                    ->icon('heroicon-o-chart-bar')
                    ->group('Laporan')
                    ->sort(4)
                    ->visible(fn (): bool => auth()->user()?->isAdmin() ?? false),
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}