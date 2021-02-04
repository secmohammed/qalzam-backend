<?php

namespace App\Domain\Reservation\Repositories\Eloquent;

use Spatie\QueryBuilder\AllowedFilter;
use App\Domain\Reservation\Entities\Reservation;
use App\Infrastructure\AbstractRepositories\EloquentRepository;
use App\Domain\Reservation\Repositories\Contracts\ReservationRepository;

/**
 * Class ReservationRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class ReservationRepositoryEloquent extends EloquentRepository implements ReservationRepository
{
    /**
     * Specify Fields
     *
     * @return string
     */
    protected $allowedFields = [
        ###allowedFields###
        ###\allowedFields###
    ];

    /**
     * @var array
     */
    protected $allowedFilters = [];

    /**
     * Include Relationships
     *
     * @return string
     */
    protected $allowedIncludes = [
        'user',
        'creator',
        'order',
        'accommodation',
        'branch',
        'order.products',
    ];

    /**
     * @var array
     */
    protected $allowedSorts = [
        'created_at',
        'start_date',
        'end_date',
    ];

    public function __construct()
    {
        parent::__construct(app());
        $this->allowedFilters = [
            AllowedFilter::exact('user.id'),
            AllowedFilter::exact('creator.id'),
            AllowedFilter::exact('branch.id'),
            AllowedFilter::scope('date_between'),

            AllowedFilter::exact('status'),
            AllowedFilter::exact('order.id'),
        ];
    }

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Reservation::class;
    }

    /**
     * Specify Model Relationships
     *
     * @return string
     */
    public function relations()
    {
        return [
            ###allowedRelations###
            ###\allowedRelations###
        ];
    }
}
