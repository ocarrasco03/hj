<?php

namespace App\Traits;

use App\Models\Sales\Order;

trait HasOrders
{
    /**
     * Get all the orders that the user owns.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function averagePurchases()
    {
        return $this->orders()
            ->withoutCanceled()
            ->withoutRefunded()
            ->avg('total');
    }

    public function sumPurchases()
    {
        return $this->orders()
            ->withoutCanceled()
            ->withoutRefunded()
            ->sum('total');
    }

    public function sumCanceledPurchases()
    {
        return $this->orders()
            ->whereHas('status', function ($query) {
                return $query->where('prefix', 'CANCELED')->orWhere('prefix', 'REFUND');
            })
            ->sum('total');
    }

    public function totalCanceledPurchases()
    {
        return $this->orders()
            ->whereHas('status', function ($query) {
                return $query->where('prefix', 'CANCELED')->orWhere('prefix', 'REFUND');
            })
            ->count();
    }

    public function totalPurchases()
    {
        return $this->orders()
            ->withoutCanceled()
            ->withoutRefunded()
            ->count();
    }

    /**
     * Getters
     */

    public function getAveragePurchasesAttribute()
    {
        return $this->averagePurchases();
    }

    public function getSumPurchasesAttribute()
    {
        return $this->sumPurchases();
    }

    public function getTotalPurchasesAttribute()
    {
        return $this->totalPurchases();
    }
}
