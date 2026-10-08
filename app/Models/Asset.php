<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Traits\LogsActivity;

class Asset extends Model
{
    use LogsActivity;
    
    protected $fillable = [
        'kode_aset',
        'nama_aset',
        'category_id',
        'merek',
        'tipe',
        'nomor_seri',
        'tahun_perolehan',
        'harga_perolehan',
        'sumber_dana',
        'jumlah',
        'satuan',
        'foto',
        'keterangan',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function assetStocks(): HasMany
    {
        return $this->hasMany(AssetStock::class);
    }

    public function assetMutations(): HasMany
    {
        return $this->hasMany(AssetMutation::class);
    }

    public function inventoryDetails(): HasMany
    {
        return $this->hasMany(InventoryDetail::class);
    }

    public function canBeDeleted(): bool
    {
        return ! $this->assetStocks()->exists()
            && ! $this->assetMutations()->exists()
            && ! $this->inventoryDetails()->exists();
    }

    public function hasFinalInventory(): bool
    {
        return $this->inventoryDetails()
            ->whereHas('inventory', function ($query) {
                $query->where('status', 'final');
            })
            ->exists();
    }
}