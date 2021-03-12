<?php

namespace App\Domain\User\Entities\Traits\Relations;

use App\Domain\Order\Entities\Order;
use App\Domain\User\Entities\Address;
use App\Domain\Branch\Entities\Branch;
use App\Domain\Product\Entities\Product;
use App\Domain\User\Entities\Remindable;
use App\Domain\User\Entities\DeviceToken;
use App\Domain\Category\Entities\Category;
use App\Domain\Discount\Entities\Discount;
use App\Domain\Product\Entities\ProductVariation;

trait UserRelations
{
    /**
     * @return mixed
     */
    public function addresses()
    {
        return $this->hasMany(Address::class);
    }

    /**
     * @return mixed
     */
    public function branches()
    {
        return $this->belongsToMany(Branch::class, 'branch_user', 'user_id', 'branch_id');
    }

    /**
     * @return mixed
     */
    public function cart()
    {
        return $this->belongsToMany(ProductVariation::class, 'cart_user')
            ->where('type', 'cart')
            ->withPivot(['quantity', 'branch_id'])->withTimestamps();
    }

    /**
     * @return mixed
     */
    public function categories()
    {
        return $this->hasMany(Category::class);
    }

    /**
     * @return mixed
     */
    public function deliverables()
    {
        return $this->belongsToMany(Order::class, 'delivery_order', 'user_id', 'order_id')->addSelect([
            'delivery_fee' => Branch::select('delivery_fee')
                ->whereColumn('id', 'orders.branch_id')
                ->limit(1),
        ]);
    }

    /**
     * @return mixed
     */
    public function deviceTokens()
    {
        return $this->hasMany(DeviceToken::class);
    }

    /**
     * @return mixed
     */
    public function discounts()
    {
        return $this->belongsToMany(Discount::class, 'discount_user', 'user_id', 'discount_id')->withPivot('used_at');
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
        return $this->hasMany(Product::class);
    }

    /**
     * define hasMany relations.
     *
     * @var array
     */
    public function remindables()
    {
        return $this->hasMany(Remindable::class);
    }

    /**
     * @return mixed
     */
    public function wishlist()
    {
        return $this->belongsToMany(ProductVariation::class, 'cart_user')->where('type', 'wishlist')->withPivot('branch_id')->withTimestamps();
    }
}
