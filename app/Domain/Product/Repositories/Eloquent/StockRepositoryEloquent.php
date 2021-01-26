<?php

namespace App\Domain\Product\Repositories\Eloquent;

use App\Domain\Product\Entities\Stock;
use Spatie\QueryBuilder\AllowedFilter;
use App\Domain\Product\Repositories\Contracts\StockRepository;
use App\Infrastructure\AbstractRepositories\EloquentRepository;

/**
 * Class StockRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class StockRepositoryEloquent extends EloquentRepository implements StockRepository
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
        'variation',
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
            AllowedFilter::exact('variation.id'),
            'status',
        ];
    }

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Stock::class;
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
