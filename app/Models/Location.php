<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Traits\LogsActivity;

class Location extends Model
{
    use LogsActivity;
    
    protected $fillable = [
        'nama_lokasi',
        'keterangan',
    ];

    public function assetStocks(): HasMany
    {
        return $this->hasMany(AssetStock::class);
    }

    public function assetMutationsAsal(): HasMany
    {
        return $this->hasMany(AssetMutation::class, 'lokasi_asal_id');
    }

    public function assetMutationsTujuan(): HasMany
    {
        return $this->hasMany(AssetMutation::class, 'lokasi_tujuan_id');
    }

    public function inventories(): HasMany
    {
        return $this->hasMany(Inventory::class);
    }
}