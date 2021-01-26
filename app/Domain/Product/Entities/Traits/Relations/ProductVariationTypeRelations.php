<?php

namespace App\Domain\Product\Entities\Traits\Relations;

use App\Domain\User\Entities\User;

trait ProductVariationTypeRelations
{
    /**
     * @return mixed
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
