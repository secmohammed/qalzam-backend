<?php

namespace App\Common\Pipeline;

use Closure;
use App\Infrastructure\Pipelines\Pipeline;

class HandleFileUpload implements Pipeline
{
    /**
     * @param $data
     * @param Closure $next
     */
    public function handle($data, Closure $next)
    {
        ['model' => $model, 'request' => $request, 'name' => $name] = $data;

        if ($request->has($name)) {

            if (!$request->file($name)) {
                return $next($model);
            }

            if (is_array($request->file($name))) {
                foreach ($request->file($name) as $file) {
                    $model->addMedia($file)->toMediaCollection($name);
                }
            } else {
                $model->addMedia($request->file($name))->toMediaCollection($name);
            }
        }

        return $next($model);
    }
}
