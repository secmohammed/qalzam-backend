<?php

namespace App\Common\Providers;

use Blade;
use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
        Event::listen(function (\Illuminate\Auth\Events\Logout $event) {
            session()->flush();
        });
        Blade::componentNamespace('App\\Common\\View\\Components', '');

        //
    }
}
