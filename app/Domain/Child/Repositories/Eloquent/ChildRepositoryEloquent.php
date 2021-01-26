<?php

namespace App\Domain\Child\Repositories\Eloquent;

use App\Domain\Child\Entities\Child;
use Spatie\QueryBuilder\AllowedFilter;
use App\Domain\Child\Repositories\Contracts\ChildRepository;
use App\Infrastructure\AbstractRepositories\EloquentRepository;

/**
 * Class ChildRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class ChildRepositoryEloquent extends EloquentRepository implements ChildRepository
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
        'competitions',
    ];

    /**
     * @var array
     */
    protected $allowedSorts = ['created_at', 'birthdate'];

    public function __construct()
    {
        parent::__construct(app());

        $this->allowedFilters = [
            'birthdate',
            AllowedFilter::exact('id'),
            'name',
            AllowedFilter::exact('gender'),
            AllowedFilter::exact('user.id'),
            AllowedFilter::exact('relation'),

        ];
    }

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Child::class;
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
