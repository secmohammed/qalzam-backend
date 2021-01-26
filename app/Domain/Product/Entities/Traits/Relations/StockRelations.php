<?php

namespace App\Domain\Product\Entities\Traits\Relations;

use App\Domain\User\Entities\User;
use App\Domain\Product\Entities\ProductVariation;

trait StockRelations
{
    /**
     * @return mixed
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return mixed
     */
    public function variation()
    {
        return $this->belongsTo(ProductVariation::class, 'product_variation_id');
    }
}
