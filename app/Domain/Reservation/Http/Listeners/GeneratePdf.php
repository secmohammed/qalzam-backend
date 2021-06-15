<?php

namespace App\Domain\Reservation\Http\Listeners;

use App\Common\Transformers\Money;
use App\Domain\Product\Entities\Template;
use App\Domain\Reservation\Http\Events\GenerateReservationPdfInvoice;
use Carbon\Carbon;
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
    public function handle(GenerateReservationPdfInvoice $event)
    {

        // Log::info("hello ", $event->reservation);
        $reservation = $event->reservation;
        // dd($reservation->accommodation->template->contracts()->ContainingDays(strtolower(Carbon::parse($reservation->start_date)->isoFormat("dddd")))->exists());
        if ($reservation->accommodation->template->contracts()->ContainingDays(strtolower(Carbon::parse($reservation->start_date)->isoFormat("dddd")))->exists()) {
            $products = $reservation->accommodation->template->products;
        } else {
            $products = Template::whereName("free")->first()->products;

        }
        $products = $products->map(function ($product) {

            $product->pivot->price = new Money($product->pivot->price);
            return $product;

        });

        // Log::info($products, $reservation);
        $pdf = PDF::loadView('reservations::reservation.invoice', ["products" => $products, "reservation" => $reservation]);
        $pdf->download($reservation->id . '.pdf');

    }
}
