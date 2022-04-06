<?php

namespace App\Models\Vehicles;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Catalog extends Model
{
    use HasFactory;

    /**
     * The relationships that should always be loaded.
     *
     * @var array
     */
    // protected $with = [
    //     'product',
    //     'year',
    //     'make',
    //     'model',
    //     'engine',
    // ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'product_id',
        'year_id',
        'make_id',
        'model_id',
        'engine_id',
        'notes',
        'attributes',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $cast = [
        'attributes' => 'array',
    ];

    public function year()
    {
        return $this->belongsTo(Year::class);
    }

    public function make()
    {
        return $this->belongsTo(Manufacturer::class);
    }

    public function model()
    {
        return $this->belongsTo(\App\Models\Vehicles\Model::class);
    }

    public function engine()
    {
        return $this->belongsTo(Engine::class);
    }

    public function product()
    {
        return $this->belongsTo(\App\Models\Catalogs\Product::class);
    }
}
