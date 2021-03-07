<?php

namespace App\Domain\Branch\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Infrastructure\AbstractModels\BaseModel as Model;
use App\Domain\Branch\Repositories\Contracts\BranchShiftRepository;
use App\Domain\Branch\Entities\Traits\Relations\BranchShiftRelations;
use App\Domain\Branch\Entities\Traits\CustomAttributes\BranchShiftAttributes;

class BranchShift extends Model
{
    use BranchShiftRelations, BranchShiftAttributes, HasFactory;

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
        'day',
        'start_time',
        'end_time',
        'status',
        'branch_id',
        'user_id',
    ];

    /**
     * The attributes that are going to be logged.
     *
     * @var array
     */
    protected static $logName = 'BranchShift';

    /**
     * Holds Repository Related to current Model.
     *
     * @var array
     */
    protected $routeRepoBinding = BranchShiftRepository::class;

    /**
     * The table name.
     *
     * @var array
     */
    protected $table = "branch_shifts";

    public static function newFactory()
    {

        return app(\App\Domain\Branch\Database\Factories\BranchShiftFactory::class)->new();
    }
}
