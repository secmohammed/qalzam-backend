<?php

namespace App\Domain\User\Entities\Traits\Relations;

use App\Domain\Location\Entities\Location;
use App\Domain\User\Entities\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait AddressRelations
{
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
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
