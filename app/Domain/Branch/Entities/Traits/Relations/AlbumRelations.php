<?php

namespace App\Domain\Branch\Entities\Traits\Relations;

use App\Domain\User\Entities\User;
use App\Domain\Branch\Entities\Branch;

trait AlbumRelations
{
    /**
     * @return mixed
     */
    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    /**
     * @return mixed
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
