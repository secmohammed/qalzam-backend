<?php

namespace App\Domain\Product\Entities;
use App\Infrastructure\AbstractModels\BaseModel as Model;

class ProductVariationOrder extends Model
{

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

    ];

    /**
     * The attributes that are going to be logged.
     *
     * @var array
     */
    protected static $logName = 'ProductVariationOrder';

    protected $table = "product_variation_order";


}
