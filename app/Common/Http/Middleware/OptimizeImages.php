<?php

namespace App\Common\Http\Middleware;

use Closure;
use Spatie\ImageOptimizer\OptimizerChain;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class OptimizeImages
{
    /**
     * @param $request
     * @param Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $optimizerChain = app(OptimizerChain::class);

        collect($request->allFiles())
            ->flatten()
            ->filter(function (UploadedFile $file) {
                if (app()->environment('testing')) {
                    return true;
                }

                return $file->isValid();
            })
            ->each(function (UploadedFile $file) use ($optimizerChain) {
                if (filesize($file) > 50000) {
                    compress_image($file->getPathname(), $file->getPathname(), 50);
                    $optimizerChain->optimize($file->getPathname());
                }

            });

        return $next($request);
    }
}
