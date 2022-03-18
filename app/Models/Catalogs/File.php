<?php

namespace App\Models\Catalogs;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'file_path'];

    public function fileable()
    {
        return $this->morphTo();
    }

    public function products()
    {
        return $this->belongsToMany(\App\Models\Catalogs\Product::class);
    }
}
