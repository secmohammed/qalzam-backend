<?php

namespace App\Domain\Order\Entities\Traits\Relations;

use App\Domain\Branch\Entities\Branch;
use App\Domain\Product\Entities\ProductVariation;
use App\Domain\User\Entities\Address;
use App\Domain\User\Entities\User;

trait OrderRelations
{
    /**
     * @return mixed
     */
    public function address()
    {
        return $this->belongsTo(Address::class);
    }

    /**
     * @return mixed
     */
    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    /**
     * @return mixed
     */
    public function products()
    {
        return $this->belongsToMany(ProductVariation::class, 'product_variation_order')
            ->withPivot(['quantity'])
            ->withTimestamps();
    }

    /**
     * @return mixed
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class);
    }

    public function deliverers()
    {
        return $this->belongsToMany(User::class, 'delivery_order', 'order_id', 'user_id');
    }
    public function scopeDeliverersWithFee($query)
    {
        return $query->addSelect([
            'delivery_fee' => Branch::select('delivery_fee')
                ->whereColumn('id', 'orders.branch_id')
                ->limit(1),
        ])->with('deliverers');
    }
}
