<?php

namespace App\Domain\Branch\Http\Resources\BranchShift;

use App\Domain\Branch\Http\Resources\Branch\BranchResource;
use App\Domain\User\Http\Resources\User\UserResource;
use App\Infrastructure\Http\AbstractResources\BaseResource as JsonResource;
use Illuminate\Http\Request;

class BranchShiftResource extends JsonResource
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
            'branch_id' => $this->branch_id,
            'user_id' => $this->user_id,
            'day' => $this->day,
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
            'branch' => new BranchResource($this->whenLoaded('branch')),
            'user' => new UserResource($this->whenLoaded('user')),
            'created_at_human' => optional($this->created_at)->diffForHumans(),
        ];
    }
}
