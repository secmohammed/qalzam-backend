<?php

namespace App\Domain\Location\Repositories\Eloquent;

use App\Domain\Location\Entities\Location;
use App\Domain\Location\Repositories\Contracts\LocationRepository;
use App\Infrastructure\AbstractRepositories\EloquentRepository;
use Spatie\QueryBuilder\AllowedFilter;

/**
 * Class LocationRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class LocationRepositoryEloquent extends EloquentRepository implements LocationRepository
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
    ];

    /**
     * Include Relationships
     *
     * @return string
     */
    protected $allowedIncludes = [
        'user',
        'parent',
        'children',

    ];

    /**
     * @var array
     */
    protected $allowedSorts = [
        'created_at',
    ];

    public function __construct()
    {
        parent::__construct(app());
        $this->allowedFilters = [
            AllowedFilter::exact('location.id'),
            AllowedFilter::scope('cityZones'),
            'name',
            'type',
            'latitude',
            'longtiude',
            'location.name',

        ];
    }

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Location::class;
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
