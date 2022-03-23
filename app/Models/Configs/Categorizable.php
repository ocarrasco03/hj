<?php

namespace App\Models\Configs;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categorizable extends Model
{
    use HasFactory;

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
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

    public function products()
    {
        return $this->belongsTo(\App\Models\Catalogs\Product::class);
    }
}
