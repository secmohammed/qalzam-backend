<?php

namespace App\Domain\Reservation\Http\Resources\Reservation;

use Illuminate\Http\Request;
use App\Domain\User\Http\Resources\User\UserResource;
use App\Domain\Order\Http\Resources\Order\OrderResource;
use App\Domain\Branch\Http\Resources\Branch\BranchResource;
use App\Infrastructure\Http\AbstractResources\BaseResource as JsonResource;
use App\Domain\Accommodation\Http\Resources\Accommodation\AccommodationResource;

class ReservationResource extends JsonResource
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
            'price' => $this->formatted_price,
            'user' => new UserResource($this->whenLoaded('user')),
            'creator' => new UserResource($this->whenLoaded('creator')),
            'branch' => new BranchResource($this->whenLoaded('branch')),
            'status' => $this->status,
            'created_at_human' => $this->created_at->diffForHumans(),
            'start_date' => $this->start_date->toDateTimeString(),
            'end_date' => $this->end_date->toDateTimeString(),
            'order' => new OrderResource($this->whenLoaded('order')),
            'accommodation' => new AccommodationResource($this->whenLoaded('accommodation')),
        ];
    }
}
