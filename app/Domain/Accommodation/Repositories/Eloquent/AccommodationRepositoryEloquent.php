<?php

namespace App\Domain\Accommodation\Repositories\Eloquent;

use Spatie\QueryBuilder\AllowedFilter;
use App\Domain\Accommodation\Entities\Accommodation;
use App\Infrastructure\AbstractRepositories\EloquentRepository;
use App\Domain\Accommodation\Repositories\Contracts\AccommodationRepository;

/**
 * Class AccommodationRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class AccommodationRepositoryEloquent extends EloquentRepository implements AccommodationRepository
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
        'user',
        'contract',
        'branch',
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
            'code',
            'name',
            AllowedFilter::exact('capacity'),
            'type',
            AllowedFilter::scope('accommodation_by_contract_containing_day'),
            AllowedFilter::exact('branch.id'),
            AllowedFilter::exact('contract.id'),
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
        return Accommodation::class;
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
