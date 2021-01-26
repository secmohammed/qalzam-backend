<?php

namespace App\Domain\Product\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Infrastructure\AbstractModels\BaseModel as Model;
use App\Domain\Product\Repositories\Contracts\ProductVariationTypeRepository;
use App\Domain\Product\Entities\Traits\Relations\ProductVariationTypeRelations;
use App\Domain\Product\Entities\Traits\CustomAttributes\ProductVariationTypeAttributes;

class ProductVariationType extends Model
{
    use ProductVariationTypeRelations, ProductVariationTypeAttributes, HasFactory;

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
        'status',
        'user_id',
    ];

    /**
     * The attributes that are going to be logged.
     *
     * @var array
     */
    protected static $logName = 'ProductVariationType';

    /**
     * Holds Repository Related to current Model.
     *
     * @var array
     */
    protected $routeRepoBinding = ProductVariationTypeRepository::class;

    /**
     * The table name.
     *
     * @var array
     */
    protected $table = "product_variation_types";

    public static function newFactory()
    {
        return app(\App\Domain\Product\Database\Factories\ProductVariationTypeFactory::class)->new();
    }
}
