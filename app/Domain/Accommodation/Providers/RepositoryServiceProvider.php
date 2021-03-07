<?php

namespace App\Domain\Accommodation\Providers;

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
        \App\Domain\Accommodation\Repositories\Contracts\AccommodationRepository::class => \App\Domain\Accommodation\Repositories\Eloquent\AccommodationRepositoryEloquent::class,
        \App\Domain\Accommodation\Repositories\Contracts\ContractRepository::class => \App\Domain\Accommodation\Repositories\Eloquent\ContractRepositoryEloquent::class,
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
