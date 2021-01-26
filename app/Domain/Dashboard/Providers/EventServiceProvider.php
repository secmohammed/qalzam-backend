<?php

namespace App\Domain\Dashboard\Providers;

use App\Domain\Dashboard\Events\Http\MessageCreated;
use App\Domain\Dashboard\Listeners\Http\BroadcastMessageToUsers;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        MessageCreated::class => [
            BroadcastMessageToUsers::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
