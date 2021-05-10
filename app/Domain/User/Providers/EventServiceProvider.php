<?php

namespace App\Domain\User\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        \App\User\Events\Common\Http\UserWasRegistered::class => [
            \App\Domain\User\Listeners\Http\SendSMSVerification::class,
        ],

		\App\Domain\User\Events\Http\UserloggedinEvent::class => [
			\App\Domain\User\Listeners\Http\SyncCartIfExistListener::class,
				###LISTENERS_Http_UserloggedinEvent###

		],
		###EVENTS###
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
