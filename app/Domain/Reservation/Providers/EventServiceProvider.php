<?php

namespace App\Domain\Reservation\Providers;

use App\Domain\Reservation\Http\Events\GenerateReservationPdfInvoice;
use App\Domain\Reservation\Http\Listeners\GeneratePdf;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        GenerateReservationPdfInvoice::class => [
            GeneratePdf::class,
        ],
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
