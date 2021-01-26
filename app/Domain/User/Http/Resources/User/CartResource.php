<?php

namespace App\Domain\User\Http\Resources\User;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Domain\User\Http\Resources\User\CartProductVariationResource;

class CartResource extends JsonResource
{
    /**
     * @param Request $request
     */
    public function toArray($request)
    {
        return [
            'products' => CartProductVariationResource::collection($this->resource),
        ];
    }
}
