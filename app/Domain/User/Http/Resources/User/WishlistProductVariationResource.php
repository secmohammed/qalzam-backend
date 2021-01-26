<?php

namespace App\Domain\User\Http\Resources\User;

use Illuminate\Http\Request;
use App\Domain\Product\Http\Resources\Product\ProductResource;
use App\Domain\Product\Http\Resources\ProductVariation\ProductVariationResource;

class WishlistProductVariationResource extends ProductVariationResource
{
    /**
     * @param Request $request
     */
    public function data(Request $request): array
    {
        return array_merge(parent::toArray($request), [
            'product' => new ProductResource($this->whenLoaded('product')),
        ]);
    }
}
