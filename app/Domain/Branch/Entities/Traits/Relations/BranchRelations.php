<?php

namespace App\Domain\Branch\Entities\Traits\Relations;

use App\Domain\Accommodation\Entities\Accommodation;
use App\Domain\Branch\Entities\Album;
use App\Domain\Branch\Entities\BranchShift;
use App\Domain\Location\Entities\Location;
use App\Domain\Order\Entities\Order;
use App\Domain\Product\Entities\Product;
use App\Domain\Product\Entities\ProductVariation;
use App\Domain\User\Entities\User;

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
    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    /**
     * @return mixed
     */
    public function deliverers()
    {
        return $this->employees()->whereHas('roles', function ($query) {
            $query->whereSlug('delivery');
        });

    }

    /**
     * @return mixed
     */
    public function employees()
    {
        return $this->belongsToMany(User::class, 'branch_user', 'branch_id', 'user_id');
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
    public function products() //todo change the relation name
    {
        return $this->belongsToMany(ProductVariation::class, 'branch_product', 'branch_id', 'product_variation_id')->withPivot('price');
    }

    /**
     * @return mixed
     */
    public function mainProducts() //todo change the relation name
    {
        return $this->belongsToMany(Product::class, 'branch_product', 'branch_id', 'product_id')->withPivot('price');
    }

    /**
     * @return mixed
     */
    public function shifts()
    {
        return $this->hasMany(BranchShift::class);
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
    public function accommodations()
    {
        return $this->hasMany(Accommodation::class);
    }
}
