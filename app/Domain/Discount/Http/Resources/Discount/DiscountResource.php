<?php

namespace App\Domain\Discount\Http\Resources\Discount;

use Illuminate\Http\Request;
use App\Domain\User\Http\Resources\User\UserResource;
use App\Infrastructure\Http\AbstractResources\BaseResource as JsonResource;

class DiscountResource extends JsonResource
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
            'code' => $this->code,
            'created_at_human' => $this->created_at->diffForHumans(),
            'expires_at_human' => optional($this->expires_at)->diffForHumans(),
            'number_of_usage' => $this->number_of_usage,
            'percentage' => $this->percentage,
            'users' => UserResource::collection($this->whenLoaded('users')),
            'owner' => new UserResource($this->whenLoaded('owner')),

        ];
    }
}
