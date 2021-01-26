<?php

namespace App\Domain\Location\Entities;

use Kalnoy\Nestedset\NodeTrait;
use Spatie\Activitylog\Traits\LogsActivity;
use Joovlly\Translatable\Traits\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Infrastructure\AbstractModels\BaseModel as Model;
use App\Domain\Location\Repositories\Contracts\LocationRepository;
use App\Domain\Location\Entities\Traits\Relations\LocationRelations;
use App\Domain\Location\Entities\Traits\CustomAttributes\LocationAttributes;

class Location extends Model
{
    use LocationRelations, LocationAttributes, NodeTrait, HasFactory, Translatable, LogsActivity;

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
        'name',
        'parent_id',
        'type',
        'status',

    ];

    /**

     * The attributes that are going to be logged.
     *
     * @var array
     */
    protected static $logName = 'Location';

    /**
     * @var mixed
     */
    protected static $logOnlyDirty = true;

    /**
     * Holds Repository Related to current Model.
     *
     * @var array
     */
    protected $routeRepoBinding = LocationRepository::class;

    /**
     * @var mixed
     */
    protected static $submitEmptyLogs = false;

    /**
     * The table name.
     *
     * @var array
     */
    protected $table = "locations";

    /**
     * @var array
     */
    protected static $translatables = ['name'];

    public static function newFactory()
    {
        return app(\App\Domain\Location\Database\Factories\LocationFactory::class)->new();
    }
}
