<?php

namespace App\Domain\Product\Repositories\Eloquent;

use App\Domain\Product\Entities\Product;
use App\Domain\Product\Repositories\Contracts\ProductRepository;
use App\Infrastructure\AbstractRepositories\EloquentRepository;
use Spatie\QueryBuilder\AllowedFilter;

/**
 * Class ProductRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class ProductRepositoryEloquent extends EloquentRepository implements ProductRepository
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
        'categories',
        'variations',
        'categories.user',
        'user.products',
        'user.categories',
        'ingredients',
    ];

    /**
     * @var array
     */
    protected $allowedSorts = ['created_at'];

    public function __construct()
    {
        parent::__construct(app());
        $this->allowedFilters = [
            AllowedFilter::scope('categories.ids', 'category_ids'),
            'name',
            'ingredients.name',
            AllowedFilter::exact('status'),
            'description',
            AllowedFilter::scope('by_name_or_category'),
            AllowedFilter::scope('price_between'),
            AllowedFilter::scope('sort_price'),

            AllowedFilter::exact('user.id'),
            AllowedFilter::exact('categories.id'),

        ];
    }

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Product::class;
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
