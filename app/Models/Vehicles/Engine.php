<?php

namespace App\Models\Vehicles;

use App\Models\Vehicles\Model as VehiclesModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Engine extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'display_name',
        'liters',
        'cilinders',
        'intake',
        'fuel',
        'valves',
    ];

    public function model()
    {
        return $this->belongsToMany(VehiclesModel::class, 'models_engines');
    }

    public function year()
    {
        return $this->belongsToMany(Year::class, 'models_engines');
    }
}
