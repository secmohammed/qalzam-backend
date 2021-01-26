<?php

namespace App\Domain\User\Entities\Traits\Relations;

use App\Domain\User\Entities\User;

trait TeamRelations
{
    /**
     * @return mixed
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    /**
     * @return mixed
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return mixed
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'team_user', 'team_id', 'user_id');
    }
}
