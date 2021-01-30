<?php

namespace App\Domain\Branch\Entities\Traits\Relations;

use App\Domain\User\Entities\User;
use App\Domain\Product\Entities\Product;
use App\Domain\Location\Entities\Location;

trait BranchRelations
{
    /**
     * @return mixed
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    /**
     * @return mixed
     */
    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    /**
     * @return mixed
     */
    public function products()
    {
        return $this->belongsToMany(Product::class, 'branch_product', 'branch_id', 'product_id');
    }

    /**
     * @return mixed
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
