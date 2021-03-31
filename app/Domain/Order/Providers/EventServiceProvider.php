<?php

namespace App\Domain\Order\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        \App\Domain\Order\Http\Events\OrderCreated::class => [
            \App\Domain\Order\Http\Listeners\EmptyCart::class,
            \App\Domain\Order\Http\Listeners\MarkOrderProcessing::class,
        ],
        \App\Domain\Order\Http\Events\OrderDestroyed::class => [
            \App\Domain\Order\Http\Listeners\RollbackStock::class,
        ],
        \App\Domain\Order\Http\Events\GenerateOrderPdfInvoice::class => [
            \App\Domain\Order\Http\Listeners\GeneratePdf::class,
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
