<?php

namespace App\Domain\Discount\Entities\Traits\Relations;

use App\Domain\User\Entities\User;

trait DiscountRelations
{
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
