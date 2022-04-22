<?php

namespace App\Models\Catalogs;

use App\Models\Configs\Category;
use App\Models\Configs\Status;
use App\Models\Sales\Order;
use App\Models\Vehicles\Catalog;
use App\Packages\Shoppingcart\Contracts\Buyable;
use App\Traits\Categorizable;
use App\Traits\Taggeable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Scout\Searchable;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use willvincent\Rateable\Rateable;

class Product extends Model implements Buyable, HasMedia
{
    use HasFactory;
    use SoftDeletes;
    use Rateable;
    use Categorizable;
    use Taggeable;
    use Searchable;
    use InteractsWithMedia;

    /**
     * The relationships that should always be loaded.
     *
     * @var array
     */
    protected $with = ['brand', 'ratings', 'categories', 'related', 'status'];

    protected $appends = ['thumb', 'media'];
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
            ->width(160)
            ->sharpen(10)
            ->nonQueued()
            ->performOnCollections('images', 'products');
    }

    /**
     * Get the indexable data array for the model.
     *
     * @return array
     */
    public function toSearchableArray()
    {
        return [
            'sku' => $this->sku,
            'name' => $this->name,
            'description' => $this->description,
            'notes' => $this->notes,
        ];
    }

    /**
     * Get the supplier that owns the product.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    /**
     * Get the brand that owns the product.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    /**
     * Get all the products that are related to this
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function related()
    {
        return $this->belongsToMany(Product::class, 'related_products', 'product_id', 'related_id');
    }

    /**
     * Get all the orders that belongs the product
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function orders()
    {
        return $this->belongsToMany(Order::class, 'order_products');
    }

    /**
     * Get all the categories that belongs to the product
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'products_categories');
    }

    /**
     * Get the status of the current order
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    public function scopeCrawler($query, $term)
    {
        return $query->where('sku', 'like', $term . '%')
            ->orWhere('name', 'like', '%' . $term . '%')
            ->orWhere('description', 'like', '%' . $term . '%')
            ->orWhere('notes', 'like', '%' . $term . '%')
            ->orWhere('attributes', 'like', '%' . $term . '%')
            ->orWhere('description', 'like', '%' . $term . '%')
            ->orWhereHas('brand', function ($query) use ($term) {
                return $query->where('name', 'like', $term . '%');
            })
            ->orWhereHas('categories', function ($query) use ($term) {
                return $query->where('name', 'like', $term . '%');
            });
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function catalogs()
    {
        return $this->hasMany(Catalog::class);
    }

    public function getThumbAttribute()
    {
        return $this->getFirstMediaUrl('products', 'thumb');
    }

    public function getMediaAttribute()
    {
        foreach ($this->media() as $media) {
            return $media->getMediaUrl();
        }
    }

}
