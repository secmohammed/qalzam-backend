<?php

namespace App\Domain\User\Entities\Traits\Relations;

use App\Domain\User\Entities\User;

trait RemindableRelations
{
    /**
     * @return mixed
     */
    public function user()
    {
        return $this->belongsto(User::class);
    }
}
