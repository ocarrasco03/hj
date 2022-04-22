<?php

namespace App\Models\Configs;

use App\Models\Sales\Order;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name', 'prefix', 'level'
    ];

    /**
     * Get all orders with the current status.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function scopeCanceled($query)
    {
        return $query->where('prefix', 'CANCELED');
    }
}
