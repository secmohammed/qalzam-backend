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
        // dd($locations);
        $data = ["order" => $event->order->load(["products", "user"]), "locations" => $locations];
        $pdf = mb_convert_encoding(\View::make('orders::order.invoice', $data), 'HTML-ENTITIES', 'UTF-8');
        return PDF::loadHtml($pdf)->download($event->order->id . '.pdf');

        // $pdf = PDF::loadView('orders::order.invoice', );
    }
}
