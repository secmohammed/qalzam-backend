<?php

namespace App\Domain\Location\Entities\Traits\Relations;

use App\Domain\User\Entities\User;
use App\Domain\Competition\Entities\Competition;

trait LocationRelations
{
    /**
     * @return mixed
     */
    public function competitions()
    {
        return $this->hasMany(Competition::class);
    }

    /**
     * @return mixed
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
