<?php

namespace App\Domain\Branch\Entities\Traits\Relations;

use App\Domain\User\Entities\User;
use App\Domain\Order\Entities\Order;
use App\Domain\Branch\Entities\Album;
use App\Domain\Product\Entities\Product;
use App\Domain\Location\Entities\Location;

trait BranchRelations
{
    /**
     * @return mixed
     */
    public function albums()
    {
        return $this->hasMany(Album::class);
    }

    /**
     * @return mixed
     */
    public function deliverers()
    {
        return $this->belongsToMany(User::class, 'branch_delivery', 'branch_id', 'user_id');

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
    public function orders()
    {
        return $this->hasMany(Order::class);
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

    /**
     * @return mixed
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'branch_user', 'branch_id', 'user_id');
    }
}
