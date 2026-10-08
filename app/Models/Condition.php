<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Traits\LogsActivity;

class Condition extends Model
{
    use LogsActivity; 
    
    protected $fillable = [
        'nama_kondisi',
        'keterangan',
    ];

    public function assetStocks(): HasMany
    {
        return $this->hasMany(AssetStock::class);
    }

    public function assetMutations(): HasMany
    {
        return $this->hasMany(AssetMutation::class);
    }
}