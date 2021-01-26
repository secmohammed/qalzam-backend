<?php

namespace App\Domain\Message\Http\Resources\Message;

use Illuminate\Http\Request;
use App\Domain\User\Http\Resources\User\UserResource;
use App\Infrastructure\Http\AbstractResources\BaseResource as JsonResource;

class MessageResource extends JsonResource
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
            'body' => $this->body,
            'title' => $this->title,
            'delayed_until' => optional($this->delay)->toDateTimeString(),
            'type' => $this->type,
            'user' => new UserResource($this->whenLoaded('user')),
            'created_at_human' => $this->created_at->diffForHumans(),
        ];
    }
}
