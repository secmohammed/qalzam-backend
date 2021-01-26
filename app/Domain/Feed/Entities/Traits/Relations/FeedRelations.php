<?php

namespace App\Domain\Feed\Entities\Traits\Relations;

use App\Domain\User\Entities\User;
use App\Domain\Child\Entities\Child;
use App\Domain\Competition\Entities\Competition;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait FeedRelations
{
    /**
     * @return mixed
     */
    public function child()
    {
        return $this->belongsTo(Child::class);
    }

    /**
     * The comments attached to the model.
     *
     * @return MorphMany
     */
    public function comments(): MorphMany
    {
        return $this->morphMany($this->commentableModel(), 'commentable')->whereNull('parent_id');
    }

    /**
     * @return mixed
     */
    public function competition()
    {
        return $this->belongsTo(Competition::class);
    }

    /**
     * @return mixed
     */
    public function competitions()
    {
        return $this->belongsTo(Competition::class, 'competition_id');
    }

    /**
     * @return mixed
     */
    public function user()
    {
        return $this->hasOneThrough(User::class, Child::class, 'id', 'id', 'child_id', 'user_id');
    }
}
