<?php

namespace App\Domain\Discount\Entities\Traits;

use App\Domain\User\Entities\User;
use App\Domain\Discount\Http\Exceptions\DiscountExpiredException;
use App\Domain\Discount\Http\Exceptions\DiscountCanNotBePurchasedException;

trait Discountable
{
    /**
     * @param  Discount      $discount
     * @param  UserInterface $user
     * @return mixed
     */
    public function attachToUser(User $user)
    {
        throw_unless($this->validate(), DiscountExpiredException::class, 'Discount is either being inactive currently or it\'s out of stock at the moment.');
        throw_if($user->id === $this->owner->id || $this->whereHas('users', function ($query) use ($user) {
            $query->whereUserId($user->id);
        })->exists(), DiscountCanNotBePurchasedException::class, 'Discount cannot be purchased.');
        $this->decrement('number_of_usage');

        $this->users()->attach($user);

        return $this;
    }

    /**
     * @param  Discount $discount
     * @return mixed
     */
    public function validate()
    {
        // if expires_at is null, it means that this discount is applicable forever.
        throw_if($this->expires_at && $this->expires_at->format('Y-m-d H:i') < now()->format('Y-m-d H:i'), DiscountExpiredException::class, 'Discount is already expired.');

        return $this->status === 'active' && $this->number_of_usage;
    }
}
