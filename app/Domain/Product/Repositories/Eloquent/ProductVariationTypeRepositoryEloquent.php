<?php

namespace App\Domain\Product\Repositories\Eloquent;

use Spatie\QueryBuilder\AllowedFilter;
use App\Domain\Product\Entities\ProductVariationType;
use App\Infrastructure\AbstractRepositories\EloquentRepository;
use App\Domain\Product\Repositories\Contracts\ProductVariationTypeRepository;

/**
 * Class ProductVariationtypeRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class ProductVariationTypeRepositoryEloquent extends EloquentRepository implements ProductVariationTypeRepository
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
            AllowedFilter::exact('user.id'),
            'status',
            'name',

        ];
    }

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return ProductVariationType::class;
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
