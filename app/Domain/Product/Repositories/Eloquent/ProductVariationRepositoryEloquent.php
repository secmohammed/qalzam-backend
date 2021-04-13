<?php

namespace App\Domain\Product\Repositories\Eloquent;

use Spatie\QueryBuilder\AllowedFilter;
use App\Domain\Product\Entities\ProductVariation;
use App\Infrastructure\Filters\CustomAllowedFilter;
use App\Infrastructure\AbstractRepositories\EloquentRepository;
use App\Domain\Product\Repositories\Contracts\ProductVariationRepository;

/**
 * Class ProductVariationRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class ProductVariationRepositoryEloquent extends EloquentRepository implements ProductVariationRepository
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
        'product',
        'type',
        'user',
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
            AllowedFilter::exact('product.id'),
            AllowedFilter::exact('type.id'),
            AllowedFilter::exact('branches.id'),
            AllowedFilter::exact('branches.accommodations.type'),
            AllowedFilter::exact('id'),
            // "id",
            // 'name',
            AllowedFilter::exact('branches.id'),
            AllowedFilter::scope('categories'),
            AllowedFilter::exact('status'),
            AllowedFilter::exact('name'),
            AllowedFilter::scope('price_between'),
            AllowedFilter::scope('sort_price'),
            CustomAllowedFilter::scope('criteria', 'by_details'),
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
        return ProductVariation::class;
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
