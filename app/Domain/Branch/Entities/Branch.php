<?php

namespace App\Domain\Branch\Entities;

use App\Common\Traits\FetchesMediaCollection;
use App\Domain\Branch\Entities\Traits\CustomAttributes\BranchAttributes;
use App\Domain\Branch\Entities\Traits\Relations\BranchRelations;
use App\Domain\Branch\Repositories\Contracts\BranchRepository;
use App\Infrastructure\AbstractModels\BaseModel as Model;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Joovlly\Translatable\Traits\Translatable;
use Spatie\MediaLibrary\HasMedia;

class Branch extends Model implements HasMedia
{
    use BranchRelations,Translatable, BranchAttributes, FetchesMediaCollection, HasFactory;

    protected static $translatables = ['name'];
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
        'delivery_fee',
        'creator_id',
        'address_1',
        'latitude',
        'longitude',
        'is_available_delivery',
        'is_available_receipt'

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

    protected $appends = ['preview_name', 'preview_status'];

    public static function newFactory()
    {
        return app(\App\Domain\Branch\Database\Factories\BranchFactory::class)->new();
    }
    public function getIsClosedAttribute()
    {
        return $this->status === "inactive" ||($this->is_available_delivery === "inactive"&&$this->is_available_receipt === "inactive") || !$this->isCurrentAvailable();
    }
    public function isCurrentAvailable()
    {
        $shift = $this->shifts()->where("day", strtolower(Carbon::now()->isoFormat("dddd")))->first();
        if (!$shift) {
            return false;
        }

        return Carbon::now()->greaterThanOrEqualTo(Carbon::parse($shift->start_time)) && Carbon::now()->lessThanOrEqualTo(Carbon::parse($shift->end_time));
    }
}
