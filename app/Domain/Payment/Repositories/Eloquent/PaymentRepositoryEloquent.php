<?php

namespace App\Domain\Payment\Repositories\Eloquent;

use App\Domain\Payment\Repositories\Contracts\PaymentRepository;
use App\Domain\Payment\Entities\Payment;
use App\Infrastructure\AbstractRepositories\EloquentRepository;

/**
 * Class PaymentRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class PaymentRepositoryEloquent extends EloquentRepository implements PaymentRepository
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
        return Payment::class;
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