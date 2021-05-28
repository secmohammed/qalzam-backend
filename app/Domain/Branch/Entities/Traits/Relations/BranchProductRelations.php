<?php

namespace App\Domain\Branch\Entities\Traits\Relations;

use App\Domain\Branch\Entities\Branch;
use App\Domain\Product\Entities\Product;
use App\Domain\Product\Entities\ProductVariation;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\Relations\MorphedByMany;

trait BranchProductRelations
{
    /**
     * @return mixed
     */
    public function product()
    {
        return $this->belongsTo(Product::class,'product_id');
    }

    /**
     * @return mixed
     */
    public function productVariation()
    {
        return $this->belongsTo(ProductVariation::class,'product_variation_id');
    }

    /**
     * @return mixed
     */
    public function branch()
    {
        return $this->belongsTo(Branch::class,'branch_id');
    }
}
