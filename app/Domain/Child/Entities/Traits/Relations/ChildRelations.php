<?php

namespace App\Domain\Child\Entities\Traits\Relations;

use App\Domain\Feed\Entities\Feed;
use App\Domain\User\Entities\User;
use App\Domain\Location\Entities\Location;
use App\Domain\Competition\Entities\Competition;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

trait ChildRelations
{
    /**
     * @return mixed
     */
    public function competitions(): BelongsToMany
    {
        return $this->belongsToMany(Competition::class, 'child_competition', 'child_id', 'competition_id');
    }

    /**
     * @return mixed
     */
    public function feeds()
    {
        return $this->hasMany(Feed::class);
    }

    /**
     * @return mixed
     */
    public function location()
    {
        return $this->hasOne(Location::class, 'id', 'location_id');
    }

    /**
     * @return mixed
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
