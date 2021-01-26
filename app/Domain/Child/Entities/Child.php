<?php

namespace App\Domain\Child\Entities;

use Spatie\MediaLibrary\HasMedia;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\MediaLibrary\InteractsWithMedia;
use Joovlly\Translatable\Traits\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Infrastructure\AbstractModels\BaseModel as Model;
use App\Domain\Child\Repositories\Contracts\ChildRepository;
use App\Domain\Child\Entities\Traits\Relations\ChildRelations;
use App\Domain\Child\Entities\Traits\CustomAttributes\ChildAttributes;

class Child extends Model implements HasMedia
{
    use ChildRelations, ChildAttributes, HasFactory, InteractsWithMedia, Translatable, LogsActivity;

    /**
     * @var array
     */
    public static $logAttributes = ["*"];

    /**
     * @var array
     */
    protected $casts = [
        'birthdate' => 'date',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'birthdate',
        'relation',
        'user_id',
        'gender',
        'status',
        'national_id',
    ];

    /**
     * The attributes that are going to be logged.
     *
     * @var array
     */
    protected static $logName = 'Child';

    /**
     * @var mixed
     */
    protected static $logOnlyDirty = true;

    /**
     * Holds Repository Related to current Model.
     *
     * @var array
     */
    protected $routeRepoBinding = ChildRepository::class;

    /**
     * @var mixed
     */
    protected static $submitEmptyLogs = false;

    /**
     * The table name.
     *
     * @var array
     */
    protected $table = "children";

    /**
     * @var array
     */
    protected static $translatables = ['name'];

    public static function newFactory()
    {
        return app(\App\Domain\Child\Database\Factories\ChildFactory::class)->new();
    }
}
