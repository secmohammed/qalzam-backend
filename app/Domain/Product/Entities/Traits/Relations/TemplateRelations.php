<?php

namespace App\Domain\Product\Entities\Traits\Relations;

use App\Domain\Accommodation\Entities\Contract;
use App\Domain\Product\Entities\Product;
use App\Domain\Product\Entities\ProductVariation;
use App\Domain\User\Entities\User;

trait TemplateRelations
{
    /**
     * @return mixed
     */
    public function products()
    {
        return $this->belongsToMany(ProductVariation::class, 'product_variation_template', 'template_id', 'product_variation_id')->withPivot(['quantity', 'price']);
    }
    public function contracts()
    {
        return $this->hasMany(Contract::class);
    }

    /**
     * @return mixed
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
