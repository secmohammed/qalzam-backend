<?php

namespace App\Domain\Message\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Infrastructure\AbstractModels\BaseModel as Model;
use App\Domain\Message\Repositories\Contracts\MessageRepository;
use App\Domain\Message\Entities\Traits\Relations\MessageRelations;
use App\Domain\Message\Entities\Traits\CustomAttributes\MessageAttributes;

class Message extends Model
{
    use MessageRelations, MessageAttributes, HasFactory;

    /**
     * @var array
     */
    public static $logAttributes = ["*"];

    /**
     * @var array
     */
    protected $casts = [
        'delay' => 'datetime',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'body',
        'title',
        'delay',
        'type',
        'competition_id',
        'user_id',
    ];

    /**
     * The attributes that are going to be logged.
     *
     * @var array
     */
    protected static $logName = 'Message';

    /**
     * Holds Repository Related to current Model.
     *
     * @var array
     */
    protected $routeRepoBinding = MessageRepository::class;

    /**
     * The table name.
     *
     * @var array
     */
    protected $table = "messages";

    /**
     * define belongsTo relations.
     *
     * @var array
     */
    private $belongsTo = [];

    /**
     * define belongsToMany relations.
     *
     * @var array
     */
    private $belongsToMany = [];

    /**
     * define hasMany relations.
     *
     * @var array
     */
    private $hasMany = [];

    public static function newFactory()
    {
        return app(\App\Domain\Message\Database\Factories\MessageFactory::class)->new();
    }
}
