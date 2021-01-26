<?php

namespace App\Domain\User\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Repositories Array With Interface as a Key and Eloquent as a Value.
     *
     * @var array
     */
    private $repositories = [
        \App\Domain\User\Repositories\Contracts\UserRepository::class => \App\Domain\User\Repositories\Eloquent\UserRepositoryEloquent::class,
        \App\Domain\User\Repositories\Contracts\RoleRepository::class => \App\Domain\User\Repositories\Eloquent\RoleRepositoryEloquent::class,
        \App\Domain\User\Repositories\Contracts\RemindableRepository::class => \App\Domain\User\Repositories\Eloquent\RemindableRepositoryEloquent::class,
        \App\Domain\User\Repositories\Contracts\NotificationRepository::class => \App\Domain\User\Repositories\Eloquent\NotificationRepositoryEloquent::class,
        \App\Domain\User\Repositories\Contracts\AddressRepository::class => \App\Domain\User\Repositories\Eloquent\AddressRepositoryEloquent::class,

        ###REPOSITORIES_PLACEHOLDER###
        // Your Repos Here "interface => eloquent class"
    ];

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        \App\Domain\User\Entities\User::observe(\App\Domain\User\Observers\UserObserver::class);
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array_keys($this->repositories);
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        /*
         * Bind all repositories to application.
         */
        foreach ($this->repositories as $interface => $eloquent) {
            $this->app->singleton($interface, $eloquent);
        }

    }
}
