<?php

namespace App\Domain\Product\Entities\Traits\Relations;

use App\Domain\Branch\Entities\Branch;
use App\Domain\User\Entities\User;
use App\Domain\Category\Entities\Category;
use App\Domain\Discount\Entities\Discount;
use App\Domain\Product\Entities\ProductVariation;

trait ProductRelations
{
    /**
     * @return mixed
     */
    public function categories()
    {
        return $this->morphToMany(Category::class, 'categorizable');
    }

    /**
     * @return mixed
     */
    public function branches()
    {
        return $this->belongsToMany(Branch::class, 'branch_product', 'product_id', 'branch_id')->withPivot('price');
    }

    /**
     * @return mixed
     */
    public function discount()
    {
        return $this->morphMany(Discount::class, 'discountable');
    }

    /**
     * @return mixed
     */
    public function ingredients()
    {
        return $this->belongsToMany(Ingredient::class, 'ingredient_product', 'product_id', 'ingredient_id');
    }

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
    public function variations()
    {
        return $this->hasMany(ProductVariation::class)->orderBy('order', 'asc');
    }
}
