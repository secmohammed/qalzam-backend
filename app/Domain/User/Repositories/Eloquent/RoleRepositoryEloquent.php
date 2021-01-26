<?php

namespace App\Domain\User\Repositories\Eloquent;

use App\Domain\User\Repositories\Contracts\RoleRepository;
use App\Domain\User\Entities\Role;
use App\Infrastructure\AbstractRepositories\EloquentRepository;

/**
 * Class RoleRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class RoleRepositoryEloquent extends EloquentRepository implements RoleRepository
{

    /**
     * Specify Fields
     *
     * @return string
     */
    protected $allowedFields = [
        ###allowedFields###
		'id',
		'name',
		'slug',
		'permissions',
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
        return Role::class;
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
