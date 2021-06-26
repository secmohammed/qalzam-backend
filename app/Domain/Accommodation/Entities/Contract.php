<?php

namespace App\Domain\Accommodation\Entities;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Infrastructure\AbstractModels\BaseModel as Model;
use App\Domain\Accommodation\Repositories\Contracts\ContractRepository;
use App\Domain\Accommodation\Entities\Traits\Relations\ContractRelations;
use App\Domain\Accommodation\Entities\Traits\CustomAttributes\ContractAttributes;

class Contract extends Model
{
    use ContractRelations, ContractAttributes, HasFactory;

    /**
     * @var array
     */
    public static $logAttributes = ["*"];

    /**
     * @var array
     */
    protected $casts = [
        'days' => 'array',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'template_id',
        'days',
        'user_id',
        'status',
    ];

    /**
     * The attributes that are going to be logged.
     *
     * @var array
     */
    protected static $logName = 'Contract';

    /**
     * Holds Repository Related to current Model.
     *
     * @var array
     */
    protected $routeRepoBinding = ContractRepository::class;

    /**
     * The table name.
     *
     * @var array
     */
    protected $table = "contracts";

    public static function newFactory()
    {
        return app(\App\Domain\Accommodation\Database\Factories\ContractFactory::class)->new();
    }

    /**
     * @param Builder $builder
     * @param $days
     */
    public function scopeContainingDays(Builder $builder, ...$days)
    {
        // dd($builder->whereJsonContains('days ', $days)->toSql(),$builder->whereJsonContains('days', $days)->getBindings());
        $builder->whereJsonContains('days', $days);
    }
}
