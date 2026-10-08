<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Traits\LogsActivity;

class Category extends Model
{
    use LogsActivity;
    
    protected $fillable = [
        'nama_kategori',
        'keterangan',
    ];

    public function assets(): HasMany
    {
        return $this->hasMany(Asset::class);
    }
}