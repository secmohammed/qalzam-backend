<?php

namespace App\Domain\User\Entities\Traits\Relations;

use App\Domain\Feed\Entities\Feed;
use App\Domain\Child\Entities\Child;
use App\Domain\Order\Entities\Order;
use App\Domain\User\Entities\Address;
use App\Domain\Product\Entities\Product;
use App\Domain\User\Entities\Remindable;
use App\Domain\User\Entities\DeviceToken;
use App\Domain\Category\Entities\Category;
use App\Domain\Discount\Entities\Discount;
use App\Domain\Reservation\Entities\Reservation;
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
    public function cart()
    {
        return $this->belongsToMany(ProductVariation::class, 'cart_user')
            ->withPivot('quantity')->withTimestamps();
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
    public function children()
    {
        return $this->hasMany(Child::class);
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
        return $this->belongsToMany(Discount::class)->withPivot('used_at');
    }

    /**
     * @return mixed
     */
    public function feeds()
    {
        return $this->hasMany(Feed::class);
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
    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    /**
     * @return mixed
     */
    public function wishlist()
    {
        return $this->belongsToMany(ProductVariation::class, 'user_wishlist')->withTimestamps();
    }
}
