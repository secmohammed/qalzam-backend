<?php

namespace App\Domain\Payment\Entities;

use App\Infrastructure\AbstractModels\BaseModel as Model;
use App\Domain\Payment\Entities\Traits\Relations\PaymentRelations;
use App\Domain\Payment\Entities\Traits\CustomAttributes\PaymentAttributes;
use App\Domain\Payment\Repositories\Contracts\PaymentRepository;

class Payment extends Model
{
    use PaymentRelations, PaymentAttributes;

    /**
     * @var array
     */
    public static $logAttributes = ["*"];

    /**
     * The attributes that are going to be logged.
     *
     * @var array
     */
    protected static $logName = 'Payment';

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
        'name'
    ];

    /**
     * The table name.
     *
     * @var array
     */
    protected $table = "payments";

    /**
     * Holds Repository Related to current Model.
     *
     * @var array
     */
    protected $routeRepoBinding = PaymentRepository::class;
}
