<?php

namespace App\Domain\Order\Http\Listeners;

use App\Domain\Order\Entities\Order;
use App\Domain\Order\Http\Events\GenerateOrderPdfInvoice;
use Log;
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

        Log::info('hey something just happened');

        $pdf = PDF::loadView('orders::order.invoice', $event->order->load(["products", "user"]));
        $pdf->stream($event->order->id . '.pdf');
        Log::info($pdf, $event->order);

    }
}
