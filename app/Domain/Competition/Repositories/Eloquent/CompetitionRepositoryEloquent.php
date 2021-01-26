<?php

namespace App\Domain\Competition\Repositories\Eloquent;

use Spatie\QueryBuilder\AllowedFilter;
use App\Domain\Competition\Entities\Competition;
use App\Infrastructure\Filters\CustomAllowedFilter;
use App\Infrastructure\AbstractRepositories\EloquentRepository;
use App\Domain\Competition\Repositories\Contracts\CompetitionRepository;

/**
 * Class CompetitionRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class CompetitionRepositoryEloquent extends EloquentRepository implements CompetitionRepository
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
        'children',
        'feeds',
        'media',
        'feeds.child',
        'feeds.user',
        'feeds.media',
        'feeds.reviews',
        'feeds.comments',
        'feeds.comments.children',
        'location',
        'location.parent',
        'location.children',
    ];

    /**
     * @var array
     */
    protected $allowedSorts = [
        'created_at',
        'start_date',
        'end_date',
    ];

    public function __construct()
    {
        parent::__construct(app());

        $this->allowedFilters = [
            AllowedFilter::scope('date_between'),
            'name',
            'featured',
            AllowedFilter::scope('gender', 'filterByGender'),
            AllowedFilter::scope('filter_by_location_and_its_children'),
            AllowedFilter::exact('type'),
            AllowedFilter::exact('status'),
            CustomAllowedFilter::scope('my_competitions'),
            AllowedFilter::scope('age_between'),
            CustomAllowedFilter::scope('with_top_rated_participants'),
            AllowedFilter::scope('with_popular_participants_based_on_location'),
            CustomAllowedFilter::scope('grouped_by_location'),
            CustomAllowedFilter::scope('active_competitions'),
            CustomAllowedFilter::scope('previous_competitions'),
        ];
    }

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Competition::class;
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
