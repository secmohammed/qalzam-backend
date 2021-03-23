<?php

namespace App\Domain\User\Entities;

use App\Domain\User\Entities\Traits\CustomAttributes\AddressAttributes;
use App\Domain\User\Entities\Traits\Relations\AddressRelations;
use App\Domain\User\Repositories\Contracts\AddressRepository;
use App\Infrastructure\AbstractModels\BaseModel as Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Activitylog\Traits\LogsActivity;

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
    public function scopeActiveAddress(Builder $builder)
    {
        // dd($builder->where("default", true);
        $builder->where("default", true);
    }
    // public function scopeLocationOfActiveAddress(Builder $builder)
    // {
    //     // dd($builder->where("default", true)->first()->location()->first());
    //     // $builder->where("default", true)->first()->location();

    //     // $this->activeAddress
    // }

}
