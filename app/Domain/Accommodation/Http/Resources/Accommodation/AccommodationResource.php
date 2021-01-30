<?php

namespace App\Domain\Accommodation\Http\Resources\Accommodation;

use Illuminate\Http\Request;
use App\Infrastructure\Http\AbstractResources\BaseResource as JsonResource;

class AccommodationResource extends JsonResource
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
