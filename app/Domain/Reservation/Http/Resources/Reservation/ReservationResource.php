<?php

namespace App\Domain\Reservation\Http\Resources\Reservation;

use Illuminate\Http\Request;
use App\Infrastructure\Http\AbstractResources\BaseResource as JsonResource;

class ReservationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function data(Request $request):array
    {
        return [
            'id'               => $this->id,
            'name'             => $this->name,
        ];
    }
}
