<?php

namespace App\Domain\Order\Http\Resources\Order;

use App\Domain\Branch\Http\Resources\Branch\BranchResource;
use Illuminate\Http\Request;
use App\Domain\User\Http\Resources\User\UserResource;
use App\Domain\User\Http\Resources\Address\AddressResource;
use App\Infrastructure\Http\AbstractResources\BaseResource as JsonResource;
use App\Domain\Product\Http\Resources\ProductVariation\ProductVariationResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function data(Request $request): array
    {

        return [
            'id' => $this->id,
            'status' => $this->status,
            'payment_type' => $this->payment_type,
            'branch' => new BranchResource($this->whenLoaded('branch')),
            'created_at' => $this->created_at->toDateTimeString(),
            'subtotal' => $this->subtotal->formatted(),
            'total' => $this->total()->formatted(),
            'user' => new UserResource($this->whenLoaded('user')),
            'creator' => new UserResource($this->whenLoaded('creator')),
            'products' => ProductVariationResource::collection(
                $this->whenLoaded('products')
            ),
            'address' => new AddressResource(
                $this->whenLoaded('address')
            ),
        ];
    }
}
