<?php

namespace App\Domain\Branch\Repositories\Eloquent;

use App\Domain\Branch\Entities\Album;
use Spatie\QueryBuilder\AllowedFilter;
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
        'user',
    ];

    /**
     * @var array
     */
    protected $allowedSorts = ['created_at'];

    public function __construct()
    {
        parent::__construct(app());
        $this->allowedFilters = [
            'branch.name',
            'name',
            AllowedFilter::exact('branch.id'),
            AllowedFilter::exact('user.id'),
        ];
    }

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
