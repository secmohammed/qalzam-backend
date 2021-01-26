<?php

namespace App\Domain\User\Repositories\Eloquent;

use App\Domain\User\Entities\Address;
use App\Domain\User\Repositories\Contracts\AddressRepository;
use App\Infrastructure\AbstractRepositories\EloquentRepository;

/**
 * Class AddressRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class AddressRepositoryEloquent extends EloquentRepository implements AddressRepository
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
    protected $allowedFilters = [
        'default',

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
        return Address::class;
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
