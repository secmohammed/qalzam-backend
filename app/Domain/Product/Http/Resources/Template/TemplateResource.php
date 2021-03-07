<?php

namespace App\Domain\Product\Http\Resources\Template;

use Illuminate\Http\Request;
use App\Domain\User\Http\Resources\User\UserResource;
use App\Infrastructure\Http\AbstractResources\BaseResource as JsonResource;
use App\Domain\Product\Http\Resources\ProductVariation\ProductVariationResource;

class TemplateResource extends JsonResource
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
            'name' => $this->name,
            'user_id' => $this->user_id,
            'user' => new UserResource($this->whenLoaded('user')),
            'products' => ProductVariationResource::collection($this->whenLoaded('products')),
            'created_at_human' => $this->created_at->diffForHumans(),
        ];
    }
}
