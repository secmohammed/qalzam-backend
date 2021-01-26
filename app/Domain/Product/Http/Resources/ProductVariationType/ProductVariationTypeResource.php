<?php

namespace App\Domain\Product\Http\Resources\ProductVariationType;

use Illuminate\Http\Request;
use App\Domain\User\Http\Resources\User\UserResource;
use App\Infrastructure\Http\AbstractResources\BaseResource as JsonResource;

class ProductVariationTypeResource extends JsonResource
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
            'user' => new UserResource($this->whenLoaded('user')),
            'name' => $this->name,
            'created_at_human' => optional($this->created_at)->diffForHumans(),
        ];
    }
}
