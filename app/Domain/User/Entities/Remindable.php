<?php

namespace App\Domain\User\Entities;

use App\Domain\User\Entities\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Infrastructure\AbstractModels\BaseModel as Model;
use App\Domain\User\Repositories\Contracts\RemindableRepository;
use App\Domain\User\Entities\Traits\Relations\RemindableRelations;
use App\Domain\User\Entities\Traits\CustomAttributes\RemindableAttributes;

class Remindable extends Model
{
    use RemindableRelations, RemindableAttributes, HasFactory;

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
        'token', 'type', 'expires_at', 'completed_at',
    ];

    /**
     * The attributes that are going to be logged.
     *
     * @var array
     */
    protected static $logName = 'Remindable';

    /**
     * Holds Repository Related to current Model.
     *
     * @var array
     */
    protected $routeRepoBinding = RemindableRepository::class;

    /**
     * The table name.
     *
     * @var array
     */
    protected $table = "remindables";

    public static function newFactory()
    {
        return app(\App\Domain\User\Database\Factories\RemindableFactory::class)->new();
    }
}
