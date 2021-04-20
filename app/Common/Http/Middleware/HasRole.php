<?php

namespace App\Common\Http\Middleware;

use Closure;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Str;

class HasRole
{
    /**
     * @var array
     */
    protected $doesntRequirePermissions = [
        'api.auth.me',
        // 'api.temlpates.products.store',
        'auth.cart.branches.index',
        'api.media.destroy',
        'api.categories.index',
        'api.branch.products.store',
        'api.auth.logout',
        'api.auth.me.update',
        'api.auth.forgot-password',
        'api.auth.reset-password',
        'api.discounts.purchase',
        'api.auth.change-password',
        'api.auth.token.refresh',
        'api.user.addresses',

        'api.city.districts',
        'api.meetings.products.store',
        'api.addresses.index',
        'api.auth.cart.destroy',
        'api.discount.validate',
        'api.auth.cart.update',
        'api.auth.cart.index',
        'api.auth.cart.store',
        'api.auth.wishlist.destroy',
        'api.auth.wishlist.update',
        'api.auth.wishlist.index',
        'api.auth.wishlist.store',
    ];

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (in_array(request()->route()->getName(), $this->doesntRequirePermissions)) {
            return $next($request);
        }
        $routeName = explode('.', request()->route()->getName());
        $module = $routeName[count($routeName) - 2];
        $permission = sprintf('%s-%s', $action = end($routeName), Str::singular($module));
        // dd($permission, auth()->user()->hasRole($permission));
        if (auth()->check() && !auth()->user()->hasRole($permission)) {
            throw new AuthorizationException(sprintf('You do not have the permission to %s %s', $action, $module), 401);

        }

        return $next($request);
    }
}
