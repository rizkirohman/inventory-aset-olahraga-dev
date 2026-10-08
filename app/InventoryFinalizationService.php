<?php

namespace App;

use App\Models\AssetStock;
use App\Models\Inventory;
use Illuminate\Support\Facades\DB;
use RuntimeException;

class InventoryFinalizationService
{
    public function finalize(Inventory $inventory): void
    {
        DB::transaction(function () use ($inventory) {
            if ($inventory->status !== 'draft') {
                throw new RuntimeException(
                    'Inventarisasi ini sudah difinalisasi dan tidak dapat diproses ulang.'
                );
            }

            $inventory->load('inventoryDetails');

            foreach ($inventory->inventoryDetails as $detail) {
                $stock = AssetStock::query()
                    ->where('asset_id', $detail->asset_id)
                    ->where('location_id', $inventory->location_id)
                    ->where('condition_id', $detail->condition_id)
                    ->lockForUpdate()
                    ->first();

                if ($detail->jumlah_ditemukan > 0) {
                    if ($stock) {
                        $stock->update([
                            'jumlah' => $detail->jumlah_ditemukan,
                        ]);
                    } else {
                        AssetStock::create([
                            'asset_id' => $detail->asset_id,
                            'location_id' => $inventory->location_id,
                            'condition_id' => $detail->condition_id,
                            'jumlah' => $detail->jumlah_ditemukan,
                        ]);
                    }
                } elseif ($stock) {
                    $stock->delete();
                }
            }

            $inventory->update([
                'status' => 'final',
            ]);
        });
    }
}