<?php

namespace App\Domain\Branch\Repositories\Eloquent;

use App\Domain\Branch\Entities\Album;
use App\Domain\Branch\Repositories\Contracts\AlbumRepository;
use App\Infrastructure\AbstractRepositories\EloquentRepository;

/**
 * Class AlbumRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class AlbumRepositoryEloquent extends EloquentRepository implements AlbumRepository
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
    protected $allowedFilters = ['branch.name', 'name'];

    /**
     * Include Relationships
     *
     * @return string
     */
    protected $allowedIncludes = [
        'branch',
    ];

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Album::class;
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
