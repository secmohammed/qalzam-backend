<?php

namespace App\Domain\Post\Entities\Traits\Relations;

use App\Domain\User\Entities\User;
use App\Domain\Category\Entities\Category;

trait PostRelations
{
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
