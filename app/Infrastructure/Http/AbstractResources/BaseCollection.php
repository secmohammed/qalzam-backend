<?php

namespace App\Infrastructure\Http\AbstractResources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class BaseCollection extends ResourceCollection
{
    /**
     * @var mixed
     */
    private $clouser;

    /**
     * Create a new resource instance.
     *
     * @param  mixed  $resource
     * @return void
     */
    public function __construct($resource, $clouser = null)
    {
        parent::__construct($resource);
        $this->clouser = $clouser;

        $this->resource = $this->collectResource($resource);
    }

    /**
     * @param $request
     * @return mixed
     */
    public function toArray($request)
    {
        return $this->collection->map->toArray($request, $this->clouser)->all();
    }
}
