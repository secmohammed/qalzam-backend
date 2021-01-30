<?php

namespace App\Domain\Accommodation\Entities;

use App\Infrastructure\AbstractModels\BaseModel as Model;
use App\Domain\Accommodation\Repositories\Contracts\AccommodationRepository;
use App\Domain\Accommodation\Entities\Traits\Relations\AccommodationRelations;
use App\Domain\Accommodation\Entities\Traits\CustomAttributes\AccommodationAttributes;

class Accommodation extends Model
{
    use AccommodationRelations, AccommodationAttributes;

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
        'price',
        'branch_id',
        'type',
        'code',
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
}
