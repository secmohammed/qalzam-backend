<?php

namespace App\Domain\User\Entities;

use App\Infrastructure\AbstractModels\BaseModel as Model;
use App\Domain\User\Repositories\Contracts\RoleUserRepository;
use App\Domain\User\Entities\Traits\Relations\RoleUserRelations;
use App\Domain\User\Entities\Traits\CustomAttributes\RoleUserAttributes;

class RoleUser extends Model
{
    use RoleUserRelations, RoleUserAttributes;

    /**
     * @var array
     */
    public static $logAttributes = ['*'];

    /**
     * The attributes that are going to be logged.
     *
     * @var array
     */
    protected static $logName = 'RoleUser';

    /**
     * define belongsTo relations.
     *
     * @var array
     */
    private $belongsTo = [];

    /**
     * define hasMany relations.
     *
     * @var array
     */
    private $hasMany = [];

    /**
     * define belongsToMany relations.
     *
     * @var array
     */
    private $belongsToMany = [];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'role_id',
    ];

    /**
     * The table name.
     *
     * @var array
     */
    protected $table = 'role_user';

    /**
     * Holds Repository Related to current Model.
     *
     * @var array
     */
    protected $routeRepoBinding = RoleUserRepository::class;
}
