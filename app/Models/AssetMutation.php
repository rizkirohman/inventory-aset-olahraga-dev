<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Traits\LogsActivity;

class AssetMutation extends Model
{
    use LogsActivity;
    
    protected $fillable = [
        'asset_id',
        'lokasi_asal_id',
        'lokasi_tujuan_id',
        'condition_id',
        'jumlah',
        'tanggal_mutasi',
        'alasan',
        'keterangan',
    ];

    protected $casts = [
        'tanggal_mutasi' => 'date',
        'jumlah' => 'integer',
    ];

    public function asset(): BelongsTo
    {
        return $this->belongsTo(Asset::class);
    }

    public function lokasiAsal(): BelongsTo
    {
        return $this->belongsTo(Location::class, 'lokasi_asal_id');
    }

    public function lokasiTujuan(): BelongsTo
    {
        return $this->belongsTo(Location::class, 'lokasi_tujuan_id');
    }

    public function condition(): BelongsTo
    {
        return $this->belongsTo(Condition::class);
    }
}