<?php

namespace App\Common\Providers;

use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;

class HelperServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->loadHelpers();
        App::bind('cart',function() {
            return new \App\Common\Helpers\Cart;
        });
        App::bind('wishlist',function() {
            return new \App\Common\Helpers\Wishlist;
        });
        App::bind('branch',function() {
            return new \App\Common\Helpers\Branch;
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
    }

    protected function loadHelpers()
    {
        foreach (glob(__DIR__.'/../Helpers/*.php') as $filename) {
            require_once $filename;
        }
    }
}
