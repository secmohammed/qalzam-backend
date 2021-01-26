<?php

namespace App\Domain\Product\Entities;

use App\Common\Traits\HasPrice;
use App\Common\Traits\FetchesMediaCollection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Infrastructure\AbstractModels\BaseModel as Model;
use App\Domain\Product\Repositories\Contracts\ProductVariationRepository;
use App\Domain\Product\Entities\Traits\Relations\ProductVariationRelations;
use App\Domain\Product\Collections\CustomProductVariationResourceCollection;
use App\Domain\Product\Entities\Traits\CustomAttributes\ProductVariationAttributes;
use App\Domain\Product\Entities\Traits\Scopes\PriceOrderable;
use App\Domain\Product\Entities\Traits\Scopes\PriceSortable;
use Illuminate\Database\Eloquent\Builder;
use Spatie\MediaLibrary\HasMedia;

class ProductVariation extends Model implements HasMedia
{
    use HasPrice, ProductVariationRelations, ProductVariationAttributes, HasFactory, FetchesMediaCollection,  PriceSortable, PriceOrderable {
        ProductVariationAttributes::getPriceAttribute insteadof HasPrice;
    }

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
        'price',
        'order',
        'status',
        'details',
        'user_id',
        'product_variation_type_id',
        'product_id',
    ];
    protected $casts = [
        'details' => 'array'
    ];

    /**
     * The attributes that are going to be logged.
     *
     * @var array
     */
    protected static $logName = 'ProductVariation';

    /**
     * Holds Repository Related to current Model.
     *
     * @var array
     */
    protected $routeRepoBinding = ProductVariationRepository::class;

    /**
     * The table name.
     *
     * @var array
     */
    protected $table = "product_variations";

    /**
     * @param array $models
     */
    public function newCollection(array $models = [])
    {
        return new CustomProductVariationResourceCollection($models);
    }

    public static function newFactory()
    {
        return app(\App\Domain\Product\Database\Factories\ProductVariationFactory::class)->new();

    }
    public function scopeByDetails(Builder $builder,  $criteria)
    {
        $builder->whereJsonContains('details', $criteria);
    }
}
