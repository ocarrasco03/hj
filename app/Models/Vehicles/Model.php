<?php

namespace App\Models\Vehicles;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model as DBModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class Model extends DBModel
{
    use HasFactory;
    use SoftDeletes;

    protected $with = ['makes', 'engines'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'make_id',
        'name',
    ];

    public function makes()
    {
        return $this->belongsTo(Manufacturer::class, 'make_id');
    }

    public function years()
    {
        return $this->belongsToMany(Year::class, 'models_years');
    }

    public function engines()
    {
        return $this->belongsToMany(Engine::class, 'models_engines');
    }
}
