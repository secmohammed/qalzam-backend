<?php

namespace App\Domain\User\Http\Resources\User;

use App\Infrastructure\Http\AbstractResources\BaseCollection as ResourceCollection;

class UserResourceCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function data(Request $request): array
    {
        return parent::toArray($request);
    }
}
