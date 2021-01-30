<?php

namespace App\Domain\Reservation\Repositories\Eloquent;

use App\Domain\Reservation\Repositories\Contracts\ReservationRepository;
use App\Domain\Reservation\Entities\Reservation;
use App\Infrastructure\AbstractRepositories\EloquentRepository;

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
     * Include Relationships
     *
     * @return string
     */
    protected $allowedIncludes = [
        ###allowedIncludes###
    	###\allowedIncludes###
    ];

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