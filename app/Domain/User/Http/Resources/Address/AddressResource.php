<?php

namespace App\Domain\User\Http\Resources\Address;

use Illuminate\Http\Request;
use App\Domain\Location\Http\Resources\Location\LocationResource;
use App\Infrastructure\Http\AbstractResources\BaseResource as JsonResource;

class AddressResource extends JsonResource
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
            'address_1' => $this->address_1,
            'postal_code' => $this->postal_code,
            'default' => $this->default,
            'location' => new LocationResource($this->whenLoaded('location')),
        ];
    }
}
