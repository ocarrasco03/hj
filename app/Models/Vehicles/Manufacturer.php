<?php

namespace App\Models\Vehicles;

use App\Models\Vehicles\Model as VehiclesModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Manufacturer extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $with = ['models'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
    ];

    public function models()
    {
        return $this->hasMany(VehiclesModel::class, 'make_id');
    }
}
