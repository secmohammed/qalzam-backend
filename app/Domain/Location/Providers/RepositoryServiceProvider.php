<?php

namespace App\Domain\Location\Providers;

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
        \App\Domain\Location\Repositories\Contracts\LocationRepository::class => \App\Domain\Location\Repositories\Eloquent\LocationRepositoryEloquent::class,
			###REPOSITORIES_PLACEHOLDER###
		// Your Repos Here "interface => eloquent class"
    ];

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        /**
         * Bind all repositories to application.
         */
        foreach ($this->repositories as $interface => $eloquent) {
            $this->app->singleton($interface, $eloquent);
        }
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
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
}
