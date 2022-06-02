<?php

namespace App\Models\Configs;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

    public function taggeable()
    {
        return $this->morphTo();
    }

    public function products()
    {
        return $this->belongsTo(\App\Models\Catalogs\Product::class);
    }
}
