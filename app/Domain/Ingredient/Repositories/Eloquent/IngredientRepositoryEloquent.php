<?php

namespace App\Domain\Ingredient\Repositories\Eloquent;

use Spatie\QueryBuilder\AllowedFilter;
use App\Domain\Ingredient\Entities\Ingredient;
use App\Infrastructure\AbstractRepositories\EloquentRepository;
use App\Domain\Ingredient\Repositories\Contracts\IngredientRepository;

/**
 * Class IngredientRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class IngredientRepositoryEloquent extends EloquentRepository implements IngredientRepository
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
        'products',
    ];

    /**
     * @var array
     */
    protected $allowedSorts = ['created_at'];

    public function __construct()
    {
        parent::__construct(app());
        $this->allowedFilters = [
            'status',
            AllowedFilter::exact('user.id'),
            'name',
            AllowedFilter::exact('products.id'),

        ];
    }

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Ingredient::class;
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
