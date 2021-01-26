<?php

namespace App\Domain\User\Providers;

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
        'user' => \App\Domain\User\Datatables\UserDatatable::class,
        'notification' => \App\Domain\User\Datatables\NotificationDatatable::class,
        'address' => \App\Domain\User\Datatables\AddressDatatable::class,
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
