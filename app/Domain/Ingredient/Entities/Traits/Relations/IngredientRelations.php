<?php

namespace App\Domain\Ingredient\Entities\Traits\Relations;

use App\Domain\User\Entities\User;
use App\Domain\Product\Entities\Product;

trait IngredientRelations
{
    /**
     * @return mixed
     */
    public function products()
    {
        return $this->belongsToMany(Product::class, 'ingredient_product', 'ingredient_id', 'product_id');
    }

    /**
     * @return mixed
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
