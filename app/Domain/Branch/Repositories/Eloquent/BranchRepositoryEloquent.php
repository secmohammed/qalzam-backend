<?php

namespace App\Domain\Branch\Repositories\Eloquent;

use App\Domain\Branch\Entities\Branch;
use Spatie\QueryBuilder\AllowedFilter;
use App\Domain\Branch\Repositories\Contracts\BranchRepository;
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
        'creator',
        'user',
        'location',
        'products',
        'albums',
        'orders',
        'shifts',
        'employees',
        'deliverers',
    ];

    /**
     * @var array
     */
    protected $allowedSorts = [
        'created_at',
        'updated_at',
    ];

    public function __construct()
    {
        parent::__construct(app());
        $this->allowedFilters = [
            AllowedFilter::exact('location.id'),
            AllowedFilter::exact('products.id'),
            AllowedFilter::exact('shifts.id'),
            AllowedFilter::exact('user.id'),
            AllowedFilter::exact('employees.id'),
            AllowedFilter::exact('deliverers.id'),
            AllowedFilter::exact('orders.id'),
            AllowedFilter::exact('albums.name'),
            'name',
            'shifts.day',

            AllowedFilter::exact('creator.id'),
        ];
    }

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
