<?php

namespace App\Common\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MediaResource extends JsonResource
{
    /**
     * @param Request $request
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'collection_name' => $this->collection_name,
            'file_name' => $this->file_name,
            'uuid' => $this->uuid,
        ];
    }
}
