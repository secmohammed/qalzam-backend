<?php

namespace App\Domain\Branch\Repositories\Eloquent;

use Spatie\QueryBuilder\AllowedFilter;
use App\Domain\Branch\Entities\BranchShift;
use App\Infrastructure\AbstractRepositories\EloquentRepository;
use App\Domain\Branch\Repositories\Contracts\BranchShiftRepository;

/**
 * Class BranchShiftRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class BranchShiftRepositoryEloquent extends EloquentRepository implements BranchShiftRepository
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
        'branch',
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
            AllowedFilter::exact('branch.id'),
            AllowedFilter::exact('user.id'),
            AllowedFilter::exact('day'),
        ];
    }

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return BranchShift::class;
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
