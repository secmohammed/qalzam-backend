<?php

namespace App\Domain\User\Http\Resources\Notification;

use Illuminate\Http\Request;
use App\Infrastructure\Http\AbstractResources\BaseResource as JsonResource;

class NotificationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function data(Request $request): array
    {
        return array_merge([
            'id' => $this->id,
            'read_at' => $this->read_at ? $this->read_at->diffForHumans() : null,

            'created_at_human' => $this->created_at->diffForHumans(),
        ], ['payload' => $this->transformData()]);
    }

    /**
     * @return mixed
     */
    protected function transformData()
    {

        return collect($this->data)->map(function ($value) {
            return $value;
        })->toArray();
    }
}
