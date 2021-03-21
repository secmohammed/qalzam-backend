<?php

namespace App\Domain\Category\Entities\Traits\Relations;

use App\Domain\Post\Entities\Post;
use App\Domain\User\Entities\User;
use App\Domain\Product\Entities\Product;

trait CategoryRelations
{
    /**
     * @return mixed
     */
    public function discounts()
    {
        return $this->morphMany(Discount::class, 'discountable');
    }

    /**
     * @return mixed
     */
    public function posts()
    {
        return $this->morphedByMany(Post::class, 'categorizable');

    }

    /**
     * @return mixed
     */
    public function products()
    {
        return $this->morphedByMany(Product::class, 'categorizable');

    }

    /**
     * @return mixed
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
