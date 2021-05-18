<?php

namespace App\Domain\Discount\Entities;

use Illuminate\Database\Eloquent\Builder;
use App\Domain\Discount\Entities\Traits\Discountable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Infrastructure\AbstractModels\BaseModel as Model;
use App\Domain\Discount\Repositories\Contracts\DiscountRepository;
use App\Domain\Discount\Entities\Traits\Relations\DiscountRelations;
use App\Domain\Discount\Entities\Traits\CustomAttributes\DiscountAttributes;

/**
 * Class Discount
 * @property $value
 * @property $code
 * @property $type
 * @property $status
 * @property $expires_at
 * @property $discountable_id
 * @property $discountable_type
 * @package App\Domain\Discount\Entities
 */
class Discount extends Model
{
    use DiscountRelations, DiscountAttributes, Discountable, HasFactory;

    /**
     * @var array
     */
    public static $logAttributes = ["*"];

    /**
     * @var array
     */
    protected $dates = ['expires_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'number_of_usage',
        'code',
        'type',
        'value',
        'status',
        'expires_at',
        'discountable_id',
        'discountable_type',
    ];

    /**
     * The attributes that are going to be logged.
     *
     * @var array
     */
    protected static $logName = 'Discount';

    /**
     * Holds Repository Related to current Model.
     *
     * @var array
     */
    protected $routeRepoBinding = DiscountRepository::class;

    /**
     * The table name.
     *
     * @var array
     */
    protected $table = "discounts";

    public static function newFactory()
    {
        return app(\App\Domain\Discount\Database\Factories\DiscountFactory::class)->new();
    }

    /**
     * @param  Builder $builder
     * @param  int     $start
     * @param  int     $end
     * @return mixed
     */
    public function scopeValueBetween(Builder $builder, int $start, int $end)
    {

        return $builder->whereBetween('value', [$start, $end]);
    }

    /**
     * @param  Builder $builder
     * @return mixed
     */
    public function scopeWithoutExpired(Builder $builder): Builder
    {
        return $builder->where(function ($query) {
            $query->where('expires_at', '>', now()->format('Y-m-d H:i'));
        })->orWhere('expires_at', '=', null);
    }
}
