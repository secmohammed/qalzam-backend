<?php

namespace App\Domain\Discount\Entities\Traits\Relations;

use App\Domain\User\Entities\User;
use App\Domain\Product\Entities\Product;
use App\Domain\Category\Entities\Category;
use App\Domain\Product\Entities\ProductVariation;
use Illuminate\Database\Eloquent\Relations\Relation;



trait DiscountRelations
{
    /**
     * @return mixed
     */
    public function discountable()
    {

        Relation::morphMap([
            'category' => Category::class,
            'product' => Product::class,
            'variation' => ProductVariation::class,
        ]);
        return $this->morphTo();
    }

    /**
     * @return mixed
     */
    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * @return mixed
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'discount_user')->withPivot('used_at');
    }
}
