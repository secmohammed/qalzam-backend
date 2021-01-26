<?php

namespace App\Domain\Feed\Repositories\Eloquent;

use App\Domain\Feed\Entities\Feed;
use Spatie\QueryBuilder\AllowedFilter;
use App\Infrastructure\Filters\CustomAllowedFilter;
use App\Domain\Feed\Repositories\Contracts\FeedRepository;
use App\Infrastructure\AbstractRepositories\EloquentRepository;

/**
 * Class FeedRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class FeedRepositoryEloquent extends EloquentRepository implements FeedRepository
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
        'child',
        'child.user',
        'competition',
        'reviews',
        'competition.children',
        'comments',
        'media',
        'comments.children',
    ];

    /**
     * @var array
     */
    protected $allowedSorts = ['created_at'];

    public function __construct()
    {
        parent::__construct(app());
        $this->allowedFilters = [
            AllowedFilter::exact('status'),
            AllowedFilter::exact('competition.id'),
            AllowedFilter::exact('user.id'),
            AllowedFilter::exact('child.id'),
            'child.name',
            'user.name',
            AllowedFilter::scope('filter_by_user_name_or_child_name'),
            CustomAllowedFilter::scope('sort_by_top_rated'),

        ];
    }

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Feed::class;
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
