<?php

namespace App\Domain\User\Entities;

use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Infrastructure\AbstractModels\BaseModel as Model;
use App\Domain\User\Repositories\Contracts\AddressRepository;
use App\Domain\User\Entities\Traits\Relations\AddressRelations;
use App\Domain\User\Entities\Traits\CustomAttributes\AddressAttributes;

class Address extends Model
{
    use AddressRelations, AddressAttributes, HasFactory, LogsActivity;

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
        'address_1',
        'default',
        'landmark',
        'postal_code',
        'user_id',
        'location_id',
    ];

    /**
     * The attributes that are going to be logged.
     *
     * @var array
     */
    protected static $logName = 'Address';

    /**
     * Holds Repository Related to current Model.
     *
     * @var array
     */
    protected $routeRepoBinding = AddressRepository::class;

    /**
     * The table name.
     *
     * @var array
     */
    protected $table = "addresses";

    public static function newFactory()
    {

        return app(\App\Domain\User\Database\Factories\AddressFactory::class)->new();
    }
}
