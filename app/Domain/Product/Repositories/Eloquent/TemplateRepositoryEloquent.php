<?php

namespace App\Domain\Product\Repositories\Eloquent;

use Spatie\QueryBuilder\AllowedFilter;
use App\Domain\Product\Entities\Template;
use App\Infrastructure\AbstractRepositories\EloquentRepository;
use App\Domain\Product\Repositories\Contracts\TemplateRepository;

/**
 * Class TemplateRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class TemplateRepositoryEloquent extends EloquentRepository implements TemplateRepository
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
    protected $allowedFilters = [];

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
            AllowedFilter::exact('products.id'),
            AllowedFilter::exact('user.id'),
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
        return Template::class;
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
