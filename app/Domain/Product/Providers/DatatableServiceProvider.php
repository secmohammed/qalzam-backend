<?php

namespace App\Domain\Product\Providers;

use Livewire;
use Illuminate\Support\ServiceProvider;

class DatatableServiceProvider extends ServiceProvider
{
    /**
     * datatables Array to be registered as Livewire components.
     *
     * @var array
     */
    private $datatables = [
        'product' => \App\Domain\Product\Datatables\ProductDatatable::class,
        'productvariation' => \App\Domain\Product\Datatables\ProductVariationDatatable::class,
        'productvariationtype' => \App\Domain\Product\Datatables\ProductVariationTypeDatatable::class,
        'stock' => \App\Domain\Product\Datatables\StockDatatable::class,
			'stock' => \App\Domain\Product\Datatables\StockDatatable::class,
			###DATATABLES_PLACEHOLDER###
        // Your datatables Here "key => class"
    ];

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        /*
         * Bind all datatables to application.
         */
        foreach ($this->datatables as $key => $class) {
            Livewire::component($key, $class);
        }
    }
}
