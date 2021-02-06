<?php

namespace App\Domain\Accommodation\Entities\Traits\Relations;

use App\Domain\User\Entities\User;
use App\Domain\Branch\Entities\Branch;
use App\Domain\Category\Entities\Category;

trait AccommodationRelations
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
    public function categories()
    {
        return $this->morphToMany(Category::class, 'categorizable');
    }

    /**
     * @return mixed
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
