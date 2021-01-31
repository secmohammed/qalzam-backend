<?php

namespace App\Domain\Branch\Entities;

use Spatie\MediaLibrary\HasMedia;
use App\Common\Traits\FetchesMediaCollection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Infrastructure\AbstractModels\BaseModel as Model;
use App\Domain\Branch\Repositories\Contracts\BranchRepository;
use App\Domain\Branch\Entities\Traits\Relations\BranchRelations;
use App\Domain\Branch\Entities\Traits\CustomAttributes\BranchAttributes;

class Branch extends Model implements HasMedia
{
    use BranchRelations, BranchAttributes, FetchesMediaCollection, HasFactory;

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
        'location_id',
        'user_id',
        'creator_id',
        'latitude',
        'longitude',

    ];

    /**
     * The attributes that are going to be logged.
     *
     * @var array
     */
    protected static $logName = 'Branch';

    /**
     * Holds Repository Related to current Model.
     *
     * @var array
     */
    protected $routeRepoBinding = BranchRepository::class;

    /**
     * The table name.
     *
     * @var array
     */
    protected $table = "branches";

    public static function newFactory()
    {
        return app(\App\Domain\Branch\Database\Factories\BranchFactory::class)->new();
    }
}
