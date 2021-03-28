<?php

namespace App\Domain\Discount\Repositories\Eloquent;

use Spatie\QueryBuilder\AllowedFilter;
use App\Domain\Discount\Entities\Discount;
use App\Infrastructure\Filters\CustomAllowedFilter;
use App\Infrastructure\AbstractRepositories\EloquentRepository;
use App\Domain\Discount\Repositories\Contracts\DiscountRepository;

/**
 * Class DiscountRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class DiscountRepositoryEloquent extends EloquentRepository implements DiscountRepository
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
        'owner',
        'users',
    ];

    public function __construct()
    {
        parent::__construct(app());
        $this->allowedFilters = [
            'code',
            CustomAllowedFilter::scope('without_expired'),
            AllowedFilter::scope('value_between'),
            AllowedFilter::exact('type'),
        ];
        $this->allowedSorts = ['created_at'];
    }

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Discount::class;
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
