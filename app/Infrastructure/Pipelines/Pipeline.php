<?php

namespace App\Infrastructure\Pipelines;

interface Pipeline
{
    /**
     * @param $data
     * @param \Closure $next
     */
    public function handle($data, \Closure $next);
}
