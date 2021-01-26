<?php

namespace App\Domain\Competition\Entities\Traits\Relations;

use App\Domain\Feed\Entities\Feed;
use App\Domain\User\Entities\User;
use App\Domain\Child\Entities\Child;
use App\Domain\Location\Entities\Location;
use App\Domain\Competition\Entities\Competition;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

trait CompetitionRelations
{
    /**
     * @return mixed
     */
    public function children(): BelongsToMany
    {
        return $this->belongsToMany(Child::class, 'child_competition', 'competition_id', 'child_id');
    }

    /**
     * @return mixed
     */
    public function feeds()
    {
        return $this->hasMany(Feed::class, 'competition_id', 'id');
    }

    /**
     * @return mixed
     */
    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    /**
     * @return mixed
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
