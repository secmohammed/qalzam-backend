<?php

namespace App\Domain\Order\Http\Listeners;

use App\Domain\Order\Entities\Order;
use App\Domain\Order\Http\Events\GenerateOrderPdfInvoice;
use PDF;

class GeneratePdf
{
    public function __construct()
    {
        set_time_limit(8000000);
    }
    /**
     * Handle the event.
     *
     * @param  OrderPaymentFailed  $event
     * @return void
     */
    public function handle(GenerateOrderPdfInvoice $event)
    {
        $locations = $event->order->user->addresses()->activeAddress()->first()->location->prevNodes()->get();

        $pdf = PDF::loadView('orders::order.invoice', ["order" => $event->order->load(["products", "user"]), "locations" => $locations]);
        return $pdf->stream($event->order->id . '.pdf');

    }
}
