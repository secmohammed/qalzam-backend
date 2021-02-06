<?php

namespace App\Domain\Branch\Http\Resources\Branch;

use Illuminate\Http\Request;
use App\Domain\User\Http\Resources\User\UserResource;
use App\Domain\Branch\Http\Resources\Album\AlbumResource;
use App\Domain\Product\Http\Resources\Product\ProductResource;
use App\Domain\Location\Http\Resources\Location\LocationResource;
use App\Infrastructure\Http\AbstractResources\BaseResource as JsonResource;

class BranchResource extends JsonResource
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
            'location_id' => $this->location_id,
            'creator_id' => $this->creator_id,
            'user_id' => $this->user_id,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'albums' => AlbumResource::collection($this->whenLoaded('albums')),
            'products' => ProductResource::collection($this->whenLoaded('products')),
            'user' => new UserResource($this->whenLoaded('user')),
            'creator' => new UserResource($this->whenLoaded('creator')),
            'location' => new LocationResource($this->whenLoaded('location')),
            'media' => $this->getMediaCollectionUrl('branch-gallery'),
            'created_at_human' => $this->created_at->diffForHumans(),
        ];
    }
}
