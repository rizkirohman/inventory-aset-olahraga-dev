<?php

namespace App\Filament\Resources\Inventories\Pages;

use App\Filament\Resources\Inventories\InventoryResource;
use App\Services\InventoryFinalizationService;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ViewRecord;

class ViewInventory extends ViewRecord
{
    protected static string $resource = InventoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            /*
             * Finalisasi - belum memiliki detail Stock Opname
             */
            Action::make('finalizeWarning')
                ->label('Finalisasi')
                ->icon('heroicon-o-check-circle')
                ->color('warning')
                ->requiresConfirmation()
                ->modalHeading('Inventarisasi Belum Dapat Difinalisasi')
                ->modalDescription(
                    'Inventarisasi ini belum memiliki Detail Stock Opname. Tambahkan minimal satu detail terlebih dahulu sebelum melakukan finalisasi.'
                )
                ->modalSubmitActionLabel('Tutup')
                ->modalCancelAction(false)
                ->visible(
                    fn (): bool =>
                        $this->record->status === 'draft'
                        && ! $this->record->inventoryDetails()->exists()
                )
                ->action(function (): void {
                    // Tidak melakukan apa-apa.
                    // Modal hanya memberikan informasi kepada pengguna.
                }),

            /*
             * Finalisasi - sudah memiliki detail Stock Opname
             */
            Action::make('finalize')
                ->label('Finalisasi')
                ->icon('heroicon-o-check-circle')
                ->color('success')
                ->requiresConfirmation()
                ->modalHeading('Finalisasi Inventarisasi')
                ->modalDescription(
                    'Setelah difinalisasi, hasil Stock Opname akan diterapkan ke stok aset dan inventarisasi tidak dapat diproses ulang.'
                )
                ->modalSubmitActionLabel('Ya, Finalisasi')
                ->modalCancelActionLabel('Batal')
                ->visible(
                    fn (): bool =>
                        $this->record->status === 'draft'
                        && $this->record->inventoryDetails()->exists()
                )
                ->action(function (): void {
                    app(InventoryFinalizationService::class)
                        ->finalize($this->record);

                    Notification::make()
                        ->success()
                        ->title('Inventarisasi berhasil difinalisasi')
                        ->body(
                            'Hasil Stock Opname telah diterapkan ke stok aset.'
                        )
                        ->send();

                    $this->redirect(
                        InventoryResource::getUrl('view', [
                            'record' => $this->record,
                        ])
                    );
                }),

            /*
             * Edit hanya tersedia untuk Draft
             */
            EditAction::make()
                ->visible(
                    fn (): bool =>
                        $this->record->status === 'draft'
                ),
        ];
    }
}