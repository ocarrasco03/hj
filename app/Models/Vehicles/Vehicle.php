<?php

namespace App\Models\Vehicles;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'year_id',
        'make_id',
        'model_id',
        'engine_id',
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
        return $this->belongsToMany(\App\Models\Catalogs\Product::class);
    }

    public function scopeFindVehicle($query, $year, $make, $model, $engine = null)
    {
        return $query->whereHas('year', function ($query) use ($year) {
            return $query->where('year', $year);
        })->whereHas('make', function ($query) use ($make) {
            return $query->where('name', $make);
        })->whereHas('model', function ($query) use ($model) {
            return $query->where('name', $model);
        })->when(!is_null($engine), function ($query) use ($engine) {
            return $query->whereHas('model', function ($query) use ($engine) {
                return $query->where('name', $engine);
            });
        });
    }
}
