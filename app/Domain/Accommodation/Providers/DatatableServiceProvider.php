<?php

namespace App\Domain\Accommodation\Providers;

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
        'accommodation' => \App\Domain\Accommodation\Datatables\AccommodationDatatable::class,
        'contract' => \App\Domain\Accommodation\Datatables\ContractDatatable::class,
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
