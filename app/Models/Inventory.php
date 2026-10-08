<?php

namespace App\Models;

use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Inventory extends Model
{
    use LogsActivity;
    
    protected $fillable = [
        'tanggal_inventarisasi',
        'location_id',
        'status',
        'keterangan',
    ];

    protected $attributes = [
        'status' => 'draft',
    ];

    protected $casts = [
        'tanggal_inventarisasi' => 'date',
    ];

    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class);
    }

    public function inventoryDetails(): HasMany
    {
        return $this->hasMany(InventoryDetail::class);
    }
}