<?php

namespace App\Domain\Branch\Http\Resources\Branch;

use App\Domain\Branch\Entities\Branch;
use App\Domain\Branch\Http\Resources\Album\AlbumResource;
use App\Domain\Branch\Http\Resources\BranchShift\BranchShiftResource;
use App\Domain\Location\Http\Resources\Location\LocationResource;
use App\Domain\Order\Http\Resources\Order\OrderResource;
use App\Domain\Product\Http\Resources\ProductVariation\ProductVariationResource;
use App\Domain\User\Http\Resources\User\UserResource;
use App\Infrastructure\Http\AbstractResources\BaseResource as JsonResource;
use Illuminate\Http\Request;

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
            'isAvailable' => $this->isBranchAvailable(),
            'shifts' => BranchShiftResource::collection($this->whenLoaded('shifts')),
            'deliverers' => UserResource::collection($this->whenLoaded('deliverers')),
            'orders' => OrderResource::collection($this->whenLoaded('orders')),
            'employees' => UserResource::collection($this->whenLoaded('employees')),
            'albums' => AlbumResource::collection($this->whenLoaded('albums')),
            'products' => ProductVariationResource::collection($this->whenLoaded('products')),
            'user' => new UserResource($this->whenLoaded('user')),
            'creator' => new UserResource($this->whenLoaded('creator')),
            'location' => new LocationResource($this->whenLoaded('location')),
            'media' => $this->getMediaCollectionUrl('branch-gallery'),
            'created_at_human' => $this->created_at->diffForHumans(),
        ];
    }
    public function isBranchAvailable()
    {
        return Branch::find($this->id)->isCurrentAvailable();
    }
}
