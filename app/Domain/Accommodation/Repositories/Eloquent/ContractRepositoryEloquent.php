<?php

namespace App\Domain\Accommodation\Repositories\Eloquent;

use Spatie\QueryBuilder\AllowedFilter;
use App\Domain\Accommodation\Entities\Contract;
use App\Infrastructure\AbstractRepositories\EloquentRepository;
use App\Domain\Accommodation\Repositories\Contracts\ContractRepository;

/**
 * Class ContractRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class ContractRepositoryEloquent extends EloquentRepository implements ContractRepository
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
        'template',
        'template.products',
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
            AllowedFilter::exact('template.id'),
            AllowedFilter::exact('user.id'),
            'name',
            AllowedFilter::scope('containing_days'),
        ];
    }

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Contract::class;
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
