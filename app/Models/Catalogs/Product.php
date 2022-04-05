<?php

namespace App\Models\Catalogs;

use App\Models\Configs\Category;
use App\Models\Vehicles\Catalog;
use App\Packages\Shoppingcart\Contracts\Buyable;
use App\Traits\Categorizable;
use App\Traits\Fileable;
use App\Traits\Taggeable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Scout\Searchable;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use willvincent\Rateable\Rateable;
use Spatie\Image\Manipulations;

class Product extends Model implements Buyable, HasMedia
{
    use HasFactory;
    use SoftDeletes;
    use Rateable;
    use Categorizable;
    use Taggeable;
    use Fileable;
    use Searchable;
    use InteractsWithMedia;

    /**
     * The relationships that should always be loaded.
     *
     * @var array
     */
    protected $with = ['brand', 'files', 'ratings', 'categories', 'catalogs', 'media'];

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
        'notes' => 'array',
    ];

    /**
     * Get the product id can be buyeable
     *
     * @param string $options
     * @return string
     */
    public function getBuyableIdentifier($options = null)
    {
        return $this->id;
    }

    /**
     * Get the product name can be buyeable
     *
     * @param string $options
     * @return string
     */
    public function getBuyableDescription($options = null)
    {
        return $this->name;
    }

    /**
     * Get the product price without tax can be buyeable
     *
     * @param float $options
     * @return float
     */
    public function getBuyablePrice($options = null)
    {
        return $this->price_wo_taxt;
    }

    /**
     * Get the product weight can be buyeable
     *
     * @param float $options
     * @return float
     */
    public function getBuyableWeight($options = null)
    {
        return $this->weight;
    }

    /**
     * Register the conversions that should be performed.
     *
     * @return array
     */
    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')
              ->height(160)
              ->sharpen(10)
              ->performOnCollections('images', 'products');
    }

    /**
     * The model belongs to a supplier model
     *
     * @return void
     */
    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    /**
     * The model belongs to a brand model
     *
     * @return void
     */
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function related()
    {
        return $this->belongsToMany(Product::class);
    }

    public function toSearchableArray()
    {
        return [
            'sku' => $this->sku,
            'name' => $this->name,
            'description' => $this->description,
            'notes' => $this->notes,
        ];
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'products_categories');
    }

    public function catalogs()
    {
        return $this->hasMany(Catalog::class);
    }

    public function getThumb()
    {
        return $this->getFirstMediaUrl('products', 'thumb');
    }


}
