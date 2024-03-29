<?php

namespace App\Domain\Product\Providers;

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
        \App\Domain\Product\Repositories\Contracts\ProductRepository::class => \App\Domain\Product\Repositories\Eloquent\ProductRepositoryEloquent::class,
        \App\Domain\Product\Repositories\Contracts\ProductVariationRepository::class => \App\Domain\Product\Repositories\Eloquent\ProductVariationRepositoryEloquent::class,
        \App\Domain\Product\Repositories\Contracts\ProductVariationTypeRepository::class => \App\Domain\Product\Repositories\Eloquent\ProductVariationTypeRepositoryEloquent::class,
        \App\Domain\Product\Repositories\Contracts\StockRepository::class => \App\Domain\Product\Repositories\Eloquent\StockRepositoryEloquent::class,
			\App\Domain\Product\Repositories\Contracts\StockRepository::class => \App\Domain\Product\Repositories\Eloquent\StockRepositoryEloquent::class,
			\App\Domain\Product\Repositories\Contracts\TemplateRepository::class => \App\Domain\Product\Repositories\Eloquent\TemplateRepositoryEloquent::class,
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
