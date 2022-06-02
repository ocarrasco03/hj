<?php

namespace App\Models\Sales;

use App\Models\Catalogs\Product;
use App\Models\Configs\Status;
use App\Models\User;
use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory;
    use Uuids;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id', 'status_id', 'subtotal', 'discount', 'tax', 'total',
    ];

    /**
     * The relationships that should always be loaded.
     *
     * @var array
     */
    protected $with = ['user', 'status'];

    /**
     * Get the user that owns the order.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get all the products the order owns
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function products()
    {
        return $this->belongsToMany(Product::class, 'order_products')
            ->withPivot([
                'quantity',
                'subtotal',
                'discount',
                'tax',
                'total'
            ]);
    }

    public function addItems($id, $qty = 0, $subtotal = 0, $total = 0, $tax = 0, $discount = 0)
    {
        return $this->products()
            ->attach($id, [
                'quantity' => $qty,
                'subtotal' => $subtotal,
                'discount' => $discount,
                'tax' => $tax,
                'total' => $total
            ]);
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

    /**
     * Get the status of the current order
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function canceledOrders()
    {
        return $this->belongsTo(Status::class)->canceled();
    }

    public function scopeSearch($query, $term)
    {
        return $query->where('id', 'like', '%' . $term . '%')
            ->orWhereHas('user', function ($query) use ($term) {
                return $query->where('name', 'like', '%' . $term . '%');
            })
            ->orWhereHas('status', function ($query) use ($term) {
                return $query->where('name', 'like', '%' . $term . '%')
                    ->orWhere('prefix', 'like', '%' . $term . '%');
            });
    }

    public function scopeWithoutCanceled($query)
    {
        return $query->whereHas('status', function ($query) {
            return $query->canceled();
        });
    }

    public function scopeOnlyCanceled($query)
    {
        return $query->whereHas('status', function ($query) {
            return $query->whereIn('prefix', ['CANCELED']);
        });
    }

    public function scopeWithoutRefunded($query)
    {
        return $query->whereHas('status', function ($query) {
            return $query->refunded();
        });
    }

    public function scopeOnlyRefunded($query)
    {
        return $query->whereHas('status', function ($query) {
            return $query->whereIn('prefix', ['REFUND']);
        });
    }

}
