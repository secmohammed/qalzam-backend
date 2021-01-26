<?php

namespace App\Domain\User\Http\Resources\User;

use Illuminate\Http\Request;
use App\Infrastructure\Http\AbstractResources\BaseResource;
use App\Domain\User\Http\Resources\User\WishlistProductVariationResource;

class WishlistResource extends BaseResource
{
    /**
     * @param Request $request
     */
    public function data(Request $request): array
    {
        return [
            'products' => WishlistProductVariationResource::collection($this->resource),
        ];
    }
}
