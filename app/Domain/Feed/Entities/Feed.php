<?php

namespace App\Domain\Feed\Entities;

use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Builder;
use Joovlly\Reviewable\Traits\HasReviews;
use Joovlly\Commentable\Traits\HasComments;
use Spatie\Activitylog\Traits\LogsActivity;
use App\Common\Traits\FetchesMediaCollection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Infrastructure\AbstractModels\BaseModel as Model;
use App\Domain\Feed\Repositories\Contracts\FeedRepository;
use App\Domain\Feed\Entities\Traits\Relations\FeedRelations;
use App\Domain\Feed\Entities\Traits\CustomAttributes\FeedAttributes;

class Feed extends Model implements HasMedia
{
    use FeedRelations, FeedAttributes, LogsActivity, FetchesMediaCollection, HasFactory, HasReviews, HasComments {
        FeedRelations::comments insteadof HasComments;
    }

    /**
     * @var array
     */
    public static $logAttributes = ["*"];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'child_id',
        'competition_id',
        'user_id',
        'status',
        'description',
    ];

    /**
     * The attributes that are going to be logged.
     *
     * @var array
     */
    protected static $logName = 'Feed';

    /**
     * Holds Repository Related to current Model.
     *
     * @var array
     */
    protected $routeRepoBinding = FeedRepository::class;

    /**
     * The table name.
     *
     * @var array
     */
    protected $table = "feeds";

    /**
     * @var array
     */
    protected $with = ['media'];

    /**
     * @var array
     */
    protected $withCount = ['reviews', 'comments'];

    public static function newFactory()
    {
        return app(\App\Domain\Feed\Database\Factories\FeedFactory::class)->new();
    }

    /**
     * @param Builder $builder
     * @param $name
     * @return mixed
     */
    public function scopeFilterByUserNameOrChildName(Builder $builder, $name)
    {
        return $builder->whereHas('user', function ($query) use ($name) {
            $query->where('users.name', 'LIKE', '%' . $name . '%');
        })->orWhereHas('child', function ($query) use ($name) {
            return $query->where('children.name', 'LIKE', '%' . $name . '%');
        });
    }

    /**
     * @param Builder $builder
     * @return mixed
     */
    public function scopeSortByTopRated(Builder $builder)
    {
        return $builder->withCount('comments')->withCount('reviews')->orderBy(
            \DB::raw("`comments_count` + `reviews_count`"), "desc"
        );
    }
}
