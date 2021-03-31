<?php

namespace App\Domain\Product\Entities;

use App\Common\Traits\FetchesMediaCollection;
use App\Common\Traits\HasPrice;
use App\Domain\Product\Collections\CustomProductVariationResourceCollection;
use App\Domain\Product\Entities\Traits\CustomAttributes\ProductVariationAttributes;
use App\Domain\Product\Entities\Traits\Relations\ProductVariationRelations;
use App\Domain\Product\Entities\Traits\Scopes\PriceOrderable;
use App\Domain\Product\Entities\Traits\Scopes\PriceSortable;
use App\Domain\Product\Repositories\Contracts\ProductVariationRepository;
use App\Infrastructure\AbstractModels\BaseModel as Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Joovlly\Translatable\Traits\Translatable;
use Spatie\MediaLibrary\HasMedia;

class ProductVariation extends Model implements HasMedia
{
    use HasPrice, ProductVariationRelations, ProductVariationAttributes, HasFactory, Translatable, FetchesMediaCollection, PriceSortable, PriceOrderable {
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
        'details' => 'array',
    ];
    protected static $translatables = ['name'];
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
    function newCollection(array $models = [])
    {
        return new CustomProductVariationResourceCollection($models);
    }

    function newFactory()
    {
        return app(\App\Domain\Product\Database\Factories\ProductVariationFactory::class)->new();

    }
    function scopeByDetails(Builder $builder, $criteria)
    {
        $builder->whereJsonContains('details', $criteria);
    }
    function scopeCategories(Builder $builder, $category_id)
    {
        // dd($category_id);
        $builder->whereHas('product.categories', function ($query) use ($category_id) {
            return $query->where('id', $category_id);
        });
    }
}
