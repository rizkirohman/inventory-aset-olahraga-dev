<?php

namespace App\Services;

use App\Models\ActivityLog;
use App\Models\AssetStock;
use App\Models\Inventory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class InventoryFinalizationService
{
    public function finalize(Inventory $inventory): void
    {
        DB::transaction(function () use ($inventory) {
            $inventory = Inventory::query()
                ->with('inventoryDetails')
                ->lockForUpdate()
                ->findOrFail($inventory->id);

            if ($inventory->status === 'final') {
                throw ValidationException::withMessages([
                    'inventory' => 'Inventarisasi ini sudah berstatus final.',
                ]);
            }

            if ($inventory->inventoryDetails->isEmpty()) {
                throw ValidationException::withMessages([
                    'inventory' => 'Inventarisasi belum memiliki detail Stock Opname.',
                ]);
            }

            foreach ($inventory->inventoryDetails as $detail) {
                $stock = AssetStock::query()
                    ->where('asset_id', $detail->asset_id)
                    ->where('location_id', $inventory->location_id)
                    ->where('condition_id', $detail->condition_id)
                    ->lockForUpdate()
                    ->first();

                if (! $stock) {
                    if ($detail->jumlah_ditemukan === 0) {
                        continue;
                    }

                    $stock = AssetStock::create([
                        'asset_id' => $detail->asset_id,
                        'location_id' => $inventory->location_id,
                        'condition_id' => $detail->condition_id,
                        'jumlah' => 0,
                    ]);
                }

                $stock->update([
                    'jumlah' => $detail->jumlah_ditemukan,
                ]);

                if ($stock->jumlah === 0) {
                    $stock->delete();
                }
            }

            /*
             * Ubah status menjadi final tanpa menjalankan
             * event LogsActivity "updated".
             */
            $inventory->withoutEvents(function () use ($inventory) {
                $inventory->update([
                    'status' => 'final',
                ]);
            });

            /*
             * Catat aktivitas khusus Finalisasi.
             */
            ActivityLog::create([
                'user_id' => Auth::id(),
                'action' => 'finalized',
                'subject_type' => Inventory::class,
                'subject_id' => $inventory->id,
                'description' => "Finalisasi Inventarisasi #{$inventory->id}",
                'old_values' => [
                    'status' => 'draft',
                ],
                'new_values' => [
                    'status' => 'final',
                ],
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
            ]);
        });
    }
}