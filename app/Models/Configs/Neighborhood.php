<?php

namespace App\Models\Configs;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Neighborhood extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name', 'zip_code_id', 'type'
    ];

    /**
     * Get the zip code that the neighborhood owns
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function zipCode()
    {
        return $this->belongsTo(ZipCode::class);
    }
}
