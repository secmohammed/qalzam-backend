<?php

namespace App\Domain\Branch\Entities\Traits\Relations;

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
}
