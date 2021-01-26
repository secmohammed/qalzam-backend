<?php

namespace App\Domain\Competition\Entities;

use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Builder;
use App\Domain\Location\Entities\Location;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\MediaLibrary\InteractsWithMedia;
use Joovlly\Translatable\Traits\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Infrastructure\AbstractModels\BaseModel as Model;
use App\Domain\Competition\Repositories\Contracts\CompetitionRepository;
use App\Domain\Competition\Entities\Traits\Relations\CompetitionRelations;
use App\Domain\Competition\Entities\Traits\CustomAttributes\CompetitionAttributes;

class Competition extends Model implements HasMedia
{
    use CompetitionRelations, CompetitionAttributes, InteractsWithMedia, Translatable, LogsActivity, HasFactory;

    /**
     * @var array
     */
    public static $logAttributes = ["*"];

    /**
     * @var array
     */
    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'start_date',
        'end_date',
        'min_age',
        'max_age',
        'gender',
        'status',
        'type',
        'user_id',
        'location_id',
        'featured',
    ];

    /**
     * The attributes that are going to be logged.
     *
     * @var array
     */
    protected static $logName = 'Competition';

    /**
     * @var mixed
     */
    protected static $logOnlyDirty = true;

    /**
     * Holds Repository Related to current Model.
     *
     * @var array
     */
    protected $routeRepoBinding = CompetitionRepository::class;

    /**
     * @var mixed
     */
    protected static $submitEmptyLogs = false;

    /**
     * The table name.
     *
     * @var array
     */
    protected $table = "competitions";

    /**
     * @var array
     */
    protected static $translatables = ['name'];

    public static function newFactory()
    {
        return app(\App\Domain\Competition\Database\Factories\CompetitionFactory::class)->new();
    }

    /**
     * @param Builder $builder
     * @return mixed
     */
    public function scopeActiveCompetitions(Builder $builder)
    {
        return $builder->whereDate('end_date', '>=', date('Y-m-d'));
    }

    /**
     * @param Builder $builder
     * @param $startAge
     * @param $endAge
     * @return mixed
     */
    public function scopeAgeBetween(Builder $builder, $startAge, $endAge)
    {
        return $builder->where('min_age', '>=', $startAge)->where('max_age', '<=', $endAge);
    }

    /**
     * @param Builder $builder
     * @param $startDate
     * @param $endDate
     * @return mixed
     */
    public function scopeDateBetween(Builder $builder, $startDate, $endDate)
    {
        return $builder->whereDate('start_date', '>=', $startDate)->whereDate('end_date', '<=', $endDate);
    }

    /**
     * @param Builder $builder
     * @param $gender
     * @return mixed
     */
    public function scopeFilterByGender(Builder $builder, $gender)
    {
        if ($gender === 'both') {
            return $builder->whereIn('gender', ['female', 'male']);
        }

        return $builder->where('gender', $gender);
    }

    /**
     * @param Builder $builder
     * @param $locationId
     * @return mixed
     */
    public function scopeFilterByLocationAndItsChildren(Builder $builder, $locationId)
    {
        $ids = array_unique(
            array_column(
                Location::where('id', $locationId)->orWhere('parent_id', $locationId)->select('id')->get()->toArray(),
                'id'
            )
        );

        return $builder->whereHas('location', function ($query) use ($ids) {
            return $query->whereIn('id', $ids)->orWhereIn('parent_id', $ids);
        });
    }

    /**
     * @param Builder $builder
     * @return mixed
     */
    public function scopeGroupedByLocation(Builder $builder)
    {
        return $builder->where('competitions.status', 'active')->whereHas('children')->join('feeds', 'feeds.competition_id', '=', 'competitions.id')
            ->join('children', 'feeds.child_id', '=', 'children.id')
            ->join('locations', 'children.location_id', '=', 'locations.id')
            ->where('locations.status', 'active')
            ->where('children.status', 'active')
            ->groupBy('locations.name');
    }

    /**
     * @param Builder $builder
     */
    public function scopeMyCompetitions(Builder $builder)
    {
        $builder->whereHas('children', function ($query) {
            $query->where('user_id', auth()->id());
        });
    }

    /**
     * @param Builder $builder
     * @return mixed
     */
    public function scopePreviousCompetitions(Builder $builder)
    {
        return $builder->whereDate('end_date', '<=', date('Y-m-d'));
    }

    /**
     * @param Builder $builder
     * @param $locationId
     * @return mixed
     */
    public function scopeWithPopularParticipantsBasedOnLocation(Builder $builder, $locationId)
    {
        return $builder->with('feeds', function ($query) {
            $query->withCount('comments')->withCount('reviews')->orderBy(
                \DB::raw("`comments_count` + `reviews_count`"), "desc"
            );
        })->whereHas('feeds.child', function ($query) use ($locationId) {
            $query->where('location_id', $locationId);
        });

    }

    /**
     * @param Builder $builder
     */
    public function scopeWithTopRatedParticipants(Builder $builder)
    {
        return $builder->with('feeds', function ($query) {
            $query->withCount('comments')->withCount('reviews')->orderBy(
                \DB::raw("`comments_count` + `reviews_count`"), "desc"
            );
        });
    }
}
