<?php

namespace App\Domain\Product\Entities\Traits\Relations;

use App\Domain\User\Entities\User;
use App\Domain\Product\Entities\Stock;
use App\Domain\Product\Entities\Product;
use App\Domain\Product\Entities\ProductVariation;
use App\Domain\Product\Entities\ProductVariationType;

trait ProductVariationRelations
{
    /**
     * @return mixed
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * @return mixed
     */
    public function stock()
    {
        return $this->belongsToMany(
            ProductVariation::class, 'product_variation_stock_view'
        )->withPivot([
            'stock', 'total_stock', 'in_stock',
        ]);
    }

    /**
     * @return mixed
     */
    public function stocks()
    {
        return $this->hasMany(Stock::class);
    }

    /**
     * @return mixed
     */
    public function type()
    {
        return $this->hasOne(ProductVariationType::class, 'id', 'product_variation_type_id');
    }

    /**
     * @return mixed
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
