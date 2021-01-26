<?php

namespace App\Common\Http\Middleware;

use Exception;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;

class GuestJWTMiddleware extends BaseMiddleware
{
    /**
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle($request, \Closure $next)
    {
        try {
            $this->checkForToken($request);

            return response()->json(['message' => 'You can not view this route, as you are having a token.']);
        } catch (Exception $e) {
            return $next($request);
        }
    }
}
