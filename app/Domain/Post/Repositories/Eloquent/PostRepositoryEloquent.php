<?php

namespace App\Domain\Post\Repositories\Eloquent;

use App\Domain\Post\Entities\Post;
use App\Domain\Post\Repositories\Contracts\PostRepository;
use App\Infrastructure\AbstractRepositories\EloquentRepository;

/**
 * Class PostRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class PostRepositoryEloquent extends EloquentRepository implements PostRepository
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
        'description',
        'title',
        'type',
        'slug',
    ];

    /**
     * Include Relationships
     *
     * @return string
     */
    protected $allowedIncludes = [
        'user',
        'categories',
        'media',
        'categories.user',
        'categories.children',
        'categories.parent',
        'categories.posts',
        'comments',
        'comments.children',
        'reviews',
    ];

    /**
     * @var array
     */
    protected $allowedSorts = ['created_at'];

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Post::class;
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
