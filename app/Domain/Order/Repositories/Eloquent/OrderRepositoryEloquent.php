<?php

namespace App\Domain\Order\Repositories\Eloquent;

use App\Domain\Order\Entities\Order;
use Spatie\QueryBuilder\AllowedFilter;
use App\Domain\Order\Repositories\Contracts\OrderRepository;
use App\Infrastructure\AbstractRepositories\EloquentRepository;

/**
 * Class OrderRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class OrderRepositoryEloquent extends EloquentRepository implements OrderRepository
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
        'products',
        'products.product',
        'products.stock',
        'address',
        'user',
        'branch',
        'products.pivot.quantity
        ',

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
            AllowedFilter::exact('address.id'),
            AllowedFilter::exact('user.id'),
            'subtotal',

        ];
    }

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Order::class;
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
