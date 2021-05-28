<?php

namespace App\Domain\Branch\Entities;

use App\Common\Traits\HasPrice;
use App\Domain\Product\Entities\Traits\Scopes\PriceOrderable;
use App\Domain\Product\Entities\Traits\Scopes\PriceSortable;
use App\Infrastructure\AbstractModels\BaseModel as Model;
use App\Domain\Branch\Entities\Traits\Relations\BranchProductRelations;
use App\Domain\Branch\Entities\Traits\CustomAttributes\BranchProductAttributes;

class BranchProduct extends Model
{
    use BranchProductRelations, BranchProductAttributes, HasPrice, PriceOrderable, PriceSortable;

    /**
     * @var array
     */
    public static $logAttributes = ["*"];

    /**
     * The attributes that are going to be logged.
     *
     * @var array
     */
    protected static $logName = 'Branch_product';

    /**
     * define belongsTo relations.
     *
     * @var array
     */
    private $belongsTo = [];

    /**
     * define hasMany relations.
     *
     * @var array
     */
    private $hasMany = [];

    /**
     * define belongsToMany relations.
     *
     * @var array
     */
    private $belongsToMany = [];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'product_id',
        'product_variation_id',
        'branch_id',
        'price'
    ];

    /**
     * The table name.
     *
     * @var array
     */
    protected $table = "branch_product";

}
