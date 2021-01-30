<?php

namespace App\Domain\Reservation\Entities\Traits\Relations;

use App\Domain\User\Entities\User;
use App\Domain\Branch\Entities\Branch;
use App\Domain\Accommodation\Entities\Accommodation;

trait ReservationRelations
{
    /**
     * @return mixed
     */
    public function accommodation()
    {
        return $this->belongsTo(Accommodation::class);
    }

    /**
     * @return mixed
     */
    public function branch()
    {
        return $this->hasOneThrough(Branch::class, Accommodation::class, 'accommodation_id', 'id', null, 'branch_id');
    }

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
}
