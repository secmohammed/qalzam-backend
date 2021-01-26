<?php

namespace App\Domain\Category\Http\Resources\Category;

use App\Infrastructure\Http\AbstractResources\BaseCollection as ResourceCollection;

class CategoryResourceCollection extends ResourceCollection
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
