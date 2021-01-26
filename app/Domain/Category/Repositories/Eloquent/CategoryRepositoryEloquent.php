<?php

namespace App\Domain\Category\Repositories\Eloquent;

use App\Domain\Category\Entities\Category;
use App\Infrastructure\AbstractRepositories\EloquentRepository;
use App\Domain\Category\Repositories\Contracts\CategoryRepository;

/**
 * Class CategoryRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class CategoryRepositoryEloquent extends EloquentRepository implements CategoryRepository
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
        'children',
        'parent',
        'user',
        // 'posts',
        // 'products'
    ];

    public function __construct()
    {
        parent::__construct(app());
        $this->allowedFilters = [
            'name',
            'type',
        ];
        $this->allowedSorts = ['created_at'];
    }

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Category::class;
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
