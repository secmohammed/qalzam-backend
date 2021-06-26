<?php

namespace App\Domain\Reservation\Http\Listeners;

use App\Common\Transformers\Money;
use App\Domain\Accommodation\Entities\Contract;
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
        $contract = $reservation->accommodation->contracts->filter(function ($item) 
        {
       return   Contract::whereId($item->id)->ContainingDays(strtolower(\Carbon\Carbon::parse('2021-10-02T17:25')->locale('en')->dayName))->exists();
        })->first();
        // dd($reservation->accommodation->template->contracts()->ContainingDays(strtolower(Carbon::parse($reservation->start_date)->isoFormat("dddd")))->exists());
        if ($contract) {

            $products = $contract->template->products;
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
