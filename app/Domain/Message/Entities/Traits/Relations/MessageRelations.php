<?php

namespace App\Domain\Message\Entities\Traits\Relations;

use App\Domain\User\Entities\User;
use App\Domain\Competition\Entities\Competition;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait MessageRelations
{
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
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
