<?php

namespace App\Domain\Branch\Providers;

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
        'branch' => \App\Domain\Branch\Datatables\BranchDatatable::class,
        'album' => \App\Domain\Branch\Datatables\AlbumDatatable::class,
        'branchshift' => \App\Domain\Branch\Datatables\BranchShiftDatatable::class,
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
