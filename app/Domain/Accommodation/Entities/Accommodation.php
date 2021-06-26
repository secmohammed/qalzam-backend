<?php

namespace App\Domain\Accommodation\Entities;

use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Builder;
use App\Common\Traits\FetchesMediaCollection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Infrastructure\AbstractModels\BaseModel as Model;
use App\Domain\Accommodation\Repositories\Contracts\AccommodationRepository;
use App\Domain\Accommodation\Entities\Traits\Relations\AccommodationRelations;
use App\Domain\Accommodation\Entities\Traits\CustomAttributes\AccommodationAttributes;

class Accommodation extends Model implements HasMedia
{
    use AccommodationRelations, AccommodationAttributes, HasFactory, FetchesMediaCollection;

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
        'branch_id',
        'name',
        'type',
        'code',
        'user_id',
        'capacity',
    ];

    /**
     * The attributes that are going to be logged.
     *
     * @var array
     */
    protected static $logName = 'Accommodation';

    /**
     * Holds Repository Related to current Model.
     *
     * @var array
     */
    protected $routeRepoBinding = AccommodationRepository::class;

    /**
     * The table name.
     *
     * @var array
     */
    protected $table = "accommodations";

    public static function newFactory()
    {

        return app(\App\Domain\Accommodation\Database\Factories\AccommodationFactory::class)->new();
    }

    /**
     * @param Builder $builder
     * @param $day
     */
    public function scopeAccommodationByContractContainingDay(Builder $builder, ...$days)
    {
        $builder->whereHas('contract', function ($query) use ($days) {
            $query->whereJsonContains('days', $days);
        });
    }
}
