<?php

namespace App\Common\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string
     */
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            if(isDashboardPath())
                return route('login');
            toastr()->warning("Oops,Just few steps to complete this request", 'login');
            session()->flash('shouldLogin');
            return url()->previous();
        }

    }
}
