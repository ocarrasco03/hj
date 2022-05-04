<?php

namespace App\Models\Vehicles;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Year extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'year',
    ];

    public function models()
    {
        return $this->belongsToMany(\App\Models\Vehicles\Model::class, 'models_years');
    }

    public function catalogs()
    {
        return $this->hasMany(Catalog::class);
    }

    public function scopeFindByYear($query, $year)
    {
        return $query->where('year', $year)->first();
    }
}
