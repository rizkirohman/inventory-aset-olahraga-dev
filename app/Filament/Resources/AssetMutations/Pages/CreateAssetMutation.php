<?php

namespace App\Filament\Resources\AssetMutations\Pages;

use App\Filament\Resources\AssetMutations\AssetMutationResource;
use App\Models\AssetStock;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class CreateAssetMutation extends CreateRecord
{
    protected static string $resource = AssetMutationResource::class;

    protected function handleRecordCreation(array $data): Model
    {
        return DB::transaction(function () use ($data) {
            $stockAsal = AssetStock::query()
                ->where('asset_id', $data['asset_id'])
                ->where('location_id', $data['lokasi_asal_id'])
                ->where('condition_id', $data['condition_id'])
                ->lockForUpdate()
                ->first();

            if (! $stockAsal) {
                throw ValidationException::withMessages([
                    'lokasi_asal_id' => 'Stok aset pada lokasi dan kondisi tersebut tidak ditemukan.',
                ]);
            }

            if ($stockAsal->jumlah < $data['jumlah']) {
                throw ValidationException::withMessages([
                    'jumlah' => "Jumlah yang dipindahkan melebihi stok tersedia. Stok tersedia: {$stockAsal->jumlah}.",
                ]);
            }

            if ($data['lokasi_asal_id'] === $data['lokasi_tujuan_id']) {
                throw ValidationException::withMessages([
                    'lokasi_tujuan_id' => 'Lokasi tujuan harus berbeda dengan lokasi asal.',
                ]);
            }

            $stockTujuan = AssetStock::query()
                ->where('asset_id', $data['asset_id'])
                ->where('location_id', $data['lokasi_tujuan_id'])
                ->where('condition_id', $data['condition_id'])
                ->lockForUpdate()
                ->first();

            if (! $stockTujuan) {
                $stockTujuan = AssetStock::create([
                    'asset_id' => $data['asset_id'],
                    'location_id' => $data['lokasi_tujuan_id'],
                    'condition_id' => $data['condition_id'],
                    'jumlah' => 0,
                ]);
            }

            $stockAsal->decrement('jumlah', $data['jumlah']);

            $stockTujuan->increment('jumlah', $data['jumlah']);

            if ($stockAsal->fresh()->jumlah === 0) {
                $stockAsal->delete();
            }

            return static::getModel()::create($data);
        });
    }

    protected function getCreatedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('Mutasi berhasil')
            ->body('Stok aset berhasil dipindahkan.');
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}