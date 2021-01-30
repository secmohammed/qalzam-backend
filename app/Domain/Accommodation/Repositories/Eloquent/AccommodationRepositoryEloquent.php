<?php

namespace App\Domain\Accommodation\Repositories\Eloquent;

use App\Domain\Accommodation\Repositories\Contracts\AccommodationRepository;
use App\Domain\Accommodation\Entities\Accommodation;
use App\Infrastructure\AbstractRepositories\EloquentRepository;

/**
 * Class AccommodationRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class AccommodationRepositoryEloquent extends EloquentRepository implements AccommodationRepository
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
        return Accommodation::class;
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