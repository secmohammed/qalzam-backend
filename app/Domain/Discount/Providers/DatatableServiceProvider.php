<?php

namespace App\Domain\Discount\Providers;

use Illuminate\Support\ServiceProvider;
use Livewire;

class DatatableServiceProvider extends ServiceProvider
{
    /**
     * datatables Array to be registered as Livewire components.
     *
     * @var array
     */
    private $datatables = [
        'discount' => \App\Domain\Discount\Datatables\DiscountDatatable::class,
			'discount' => \App\Domain\Discount\Datatables\DiscountDatatable::class,
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
        /**
         * Bind all datatables to application.
         */
        foreach ($this->datatables as $key => $class) {
            Livewire::component($key,$class);
        }
    }
}