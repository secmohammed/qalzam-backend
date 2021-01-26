<?php

namespace App\Domain\Product\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Infrastructure\AbstractModels\BaseModel as Model;
use App\Domain\Product\Repositories\Contracts\StockRepository;
use App\Domain\Product\Entities\Traits\Relations\StockRelations;
use App\Domain\Product\Entities\Traits\CustomAttributes\StockAttributes;

class Stock extends Model
{
    use StockRelations, StockAttributes, HasFactory;

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
        'quantity',
        'status',
        'product_variation_id',
        'user_id',
    ];

    /**
     * The attributes that are going to be logged.
     *
     * @var array
     */
    protected static $logName = 'Stock';

    /**
     * Holds Repository Related to current Model.
     *
     * @var array
     */
    protected $routeRepoBinding = StockRepository::class;

    /**
     * The table name.
     *
     * @var array
     */
    protected $table = "stocks";

    public static function newFactory()
    {
        return app(\App\Domain\Product\Database\Factories\StockFactory::class)->new();
    }
}
