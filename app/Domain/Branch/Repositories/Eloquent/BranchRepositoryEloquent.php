<?php

namespace App\Domain\Branch\Repositories\Eloquent;

use App\Domain\Branch\Repositories\Contracts\BranchRepository;
use App\Domain\Branch\Entities\Branch;
use App\Infrastructure\AbstractRepositories\EloquentRepository;

/**
 * Class BranchRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class BranchRepositoryEloquent extends EloquentRepository implements BranchRepository
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
        return Branch::class;
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