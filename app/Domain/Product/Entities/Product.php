<?php

namespace App\Domain\Product\Entities;

use App\Common\Traits\HasPrice;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Builder;
use App\Common\Traits\FetchesMediaCollection;
use Joovlly\Translatable\Traits\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Infrastructure\AbstractModels\BaseModel as Model;
use App\Domain\Product\Entities\Traits\Scopes\PriceSortable;
use App\Domain\Product\Entities\Traits\Scopes\PriceOrderable;
use App\Domain\Product\Repositories\Contracts\ProductRepository;
use App\Domain\Product\Entities\Traits\Relations\ProductRelations;
use App\Domain\Product\Entities\Traits\CustomAttributes\ProductAttributes;

class Product extends Model implements HasMedia
{
    use ProductRelations, ProductAttributes, HasFactory, FetchesMediaCollection, Translatable, HasPrice, PriceOrderable, PriceSortable;

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
        'price',
        'description',
        'user_id',
        'slug',
    ];

    /**
     * The attributes that are going to be logged.
     *
     * @var array
     */
    protected static $logName = 'Product';

    /**
     * Holds Repository Related to current Model.
     *
     * @var array
     */
    protected $routeRepoBinding = ProductRepository::class;

    /**
     * The table name.
     *
     * @var array
     */
    protected $table = "products";

    /**
     * @var array
     */
    protected static $translatables = [];

    public static function newFactory()
    {
        return app(\App\Domain\Product\Database\Factories\ProductFactory::class)->new();
    }

    /**
     * @param Builder $query
     * @param $name
     * @return mixed
     */
    public function scopeByNameOrCategory(Builder $query, $name): Builder
    {
        return $query->whereHas('categories', function ($query) use ($name) {
            $query->where('name', 'LIKE', '%' . $name . '%');
        })->orWhere('name', $name);
    }

    /**
     * @param Builder $builder
     * @param $ids
     * @return mixed
     */
    public function scopeCategoryIds(Builder $builder, ...$ids)
    {
        return $builder->whereHas('categories', function ($query) use ($ids) {
            return $query->whereIn('id', $ids);
        });
    }
}
