<?php

namespace App\Domain\User\Http\Resources\User;

use App\Common\Transformers\Money;
use App\Domain\Product\Http\Resources\ProductVariation\ProductVariationResource;
use App\Domain\Product\Http\Resources\Product\ProductResource;
use Illuminate\Http\Request;

class CartProductVariationResource extends ProductVariationResource
{
    /**
     * @param Request $request
     */
    public function data(Request $request): array
    {
        return array_merge(parent::toArray($request), [
            'product' => new ProductResource($this->whenLoaded('product')),
            'quantity' => $this->pivot->quantity,
            'total' => $this->getTotal()->formatted(),
        ]);
    }

    protected function getTotal()
    {
        return new Money($this->pivot->quantity * $this->price->amount());
    }
}
