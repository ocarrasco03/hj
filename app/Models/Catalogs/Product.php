<?php

namespace App\Models\Catalogs;

use willvincent\Rateable\Rateable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Packages\Shoppingcart\Contracts\Buyable;
use App\Traits\Categorizable;
use App\Traits\Taggeable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model implements Buyable
{
    use HasFactory, SoftDeletes, Rateable, Categorizable, Taggeable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'brand_id',
        'supplier_id',
        'sku',
        'slug',
        'name',
        'description',
        'cost',
        'price_wo_tax',
        'price',
        'unit',
        'stock',
        'notes',
        'weight',
        'condition',
    ];

    protected $casts = [
        'notes' => 'array'
    ];

    /**
     * Get the product id can be buyeable
     *
     * @param string $options
     * @return string
     */
    public function getBuyableIdentifier($options = null) {
        return $this->id;
    }

    /**
     * Get the product name can be buyeable
     *
     * @param string $options
     * @return string
     */
    public function getBuyableDescription($options = null) {
        return $this->name;
    }

    /**
     * Get the product price without tax can be buyeable
     *
     * @param float $options
     * @return float
     */
    public function getBuyablePrice($options = null) {
        return $this->price_wo_taxt;
    }

    /**
     * Get the product weight can be buyeable
     *
     * @param float $options
     * @return float
     */
    public function getBuyableWeight($options = null) {
        return $this->weight;
    }
}
