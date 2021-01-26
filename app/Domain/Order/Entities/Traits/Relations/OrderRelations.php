<?php

namespace App\Domain\Order\Entities\Traits\Relations;

use App\Domain\User\Entities\User;
use App\Domain\User\Entities\Address;
use App\Domain\Product\Entities\ProductVariation;

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
}
