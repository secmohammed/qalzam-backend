<?php

namespace App\Domain\Category\Entities\Traits\Relations;

use App\Domain\Accommodation\Entities\Accommodation;
use App\Domain\Post\Entities\Post;
use App\Domain\Product\Entities\Product;
use App\Domain\User\Entities\User;

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
    public function accommodations()
    {
        return $this->morphedByMany(Accommodation::class, 'categorizable');

    }

    /**
     * @return mixed
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
