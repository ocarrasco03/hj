<?php

namespace App\Models\Configs;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categorizable extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'category_id',
    ];

    public function categorizable()
    {
        return $this->morphTo();
    }

    public function category()
    {
        return $this->belongsTo(\App\Models\Configs\Category::class);
    }
}
