<?php

namespace App\Domain\Reservation\Entities;

use App\Common\Traits\HasPrice;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Infrastructure\AbstractModels\BaseModel as Model;
use App\Domain\Product\Entities\Traits\Scopes\PriceSortable;
use App\Domain\Product\Entities\Traits\Scopes\PriceOrderable;
use App\Domain\Reservation\Repositories\Contracts\ReservationRepository;
use App\Domain\Reservation\Entities\Traits\Relations\ReservationRelations;
use App\Domain\Reservation\Entities\Traits\CustomAttributes\ReservationAttributes;

class Reservation extends Model
{
    use ReservationRelations, ReservationAttributes, HasFactory, HasPrice, PriceOrderable, PriceSortable;

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
        'order_id',
        'status',
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

    public static function newFactory()
    {
        return app(\App\Domain\Reservation\Database\Factories\ReservationFactory::class)->new();
    }

    /**
     * @param Builder $builder
     * @param $startDate
     * @param $endDate
     * @return mixed
     */
    public function scopeDateBetween(Builder $builder, $startDate, $endDate)
    {
        return $builder->whereDate('start_date', '>=', $startDate)->whereDate('end_date', '<=', $endDate);
    }
}
