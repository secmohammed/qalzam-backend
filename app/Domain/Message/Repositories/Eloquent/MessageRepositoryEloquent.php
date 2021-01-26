<?php

namespace App\Domain\Message\Repositories\Eloquent;

use App\Domain\Message\Repositories\Contracts\MessageRepository;
use App\Domain\Message\Entities\Message;
use App\Infrastructure\AbstractRepositories\EloquentRepository;

/**
 * Class MessageRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class MessageRepositoryEloquent extends EloquentRepository implements MessageRepository
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
        return Message::class;
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