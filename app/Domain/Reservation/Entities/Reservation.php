<?php

namespace App\Domain\Reservation\Entities;

use App\Infrastructure\AbstractModels\BaseModel as Model;
use App\Domain\Reservation\Repositories\Contracts\ReservationRepository;
use App\Domain\Reservation\Entities\Traits\Relations\ReservationRelations;
use App\Domain\Reservation\Entities\Traits\CustomAttributes\ReservationAttributes;

class Reservation extends Model
{
    use ReservationRelations, ReservationAttributes;

    /**
     * @var array
     */
    public static $logAttributes = ["*"];

    /**
     * @var array
     */
    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'start_date',
        'end_date',
        'price',
        'user_id',
        'creator_id',
        'accommodation_id',
    ];

    /**
     * The attributes that are going to be logged.
     *
     * @var array
     */
    protected static $logName = 'Reservation';

    /**
     * Holds Repository Related to current Model.
     *
     * @var array
     */
    protected $routeRepoBinding = ReservationRepository::class;

    /**
     * The table name.
     *
     * @var array
     */
    protected $table = "reservations";
}
