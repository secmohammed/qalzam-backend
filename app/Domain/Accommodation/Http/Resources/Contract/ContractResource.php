<?php

namespace App\Domain\Accommodation\Http\Resources\Contract;

use Illuminate\Http\Request;
use App\Domain\User\Http\Resources\User\UserResource;
use App\Domain\Product\Http\Resources\Template\TemplateResource;
use App\Infrastructure\Http\AbstractResources\BaseResource as JsonResource;

class ContractResource extends JsonResource
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
            'days' => $this->days,
            'template_id' => $this->template_id,
            'user_id' => $this->user_id,
            'user' => new UserResource($this->whenLoaded('user')),
            'template' => new TemplateResource($this->whenLoaded('template')),
            'created_at_human' => $this->created_at->diffForHumans(),
        ];
    }
}
