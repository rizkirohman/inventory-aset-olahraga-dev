<?php

namespace App\Models;

use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InventoryDetail extends Model
{
    use LogsActivity;
    
    protected $fillable = [
        'inventory_id',
        'asset_id',
        'condition_id',
        'jumlah_tercatat',
        'jumlah_ditemukan',
        'selisih',
        'keterangan',
    ];

    protected $casts = [
        'jumlah_tercatat' => 'integer',
        'jumlah_ditemukan' => 'integer',
        'selisih' => 'integer',
    ];

    public function inventory(): BelongsTo
    {
        return $this->belongsTo(Inventory::class);
    }

    public function asset(): BelongsTo
    {
        return $this->belongsTo(Asset::class);
    }

    public function condition(): BelongsTo
    {
        return $this->belongsTo(Condition::class);
    }
}