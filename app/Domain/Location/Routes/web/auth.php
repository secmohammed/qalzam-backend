<?php

use App\Domain\Order\Entities\Order;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

Route::middleware(['auth'])->group(function () {
    Route::resource('/locations', 'LocationController');
    Route::get('/welcome', function () {
        // GenerateOrderPdfInvoice::dispatch(Order::all()->first());
        // Carbon::parse(Reservation::first()->start_date)->isoFormat("dddd");
        // dd(Reservation::first());
        // dd(Reservation::first()->accommodation->template->products, strtolower(Carbon::parse(Reservation::first()->start_date)->isoFormat("dddd")), Reservation::first()->accommodation->template->contracts()->ContainingDays(strtolower(Carbon::parse(Reservation::first()->start_date)->isoFormat("dddd")))->first());
        // if in contract

        // out contract

        // return view("reservations::invoice", ["order" => Order::first()->load(["products", "user"])]);
        $order = Order::first()->load(["products", "user"]);
        // $order->branch->products()->attach($order->products);
        // dd($order->branch_id);
        // Money
        // session(["current_branch" => $order->branch_id]);
        // $reservation = Reservation::first();
        // dd($reservation->accommodation->template->contracts);
        // if ($reservation->accommodation->template->contracts()->ContainingDays(strtolower(Carbon::parse(Reservation::first()->start_date)->isoFormat("dddd")))->exists()) {
        //     $products = $reservation->accommodation->template->products;
        // } else {
        //     $products = Template::whereName("free")->first()->products;

        // }
        // $products = $products->map(function ($product) {

        //     $product->pivot->price = new Money($product->pivot->price);
        //     return $product;

        // });
        // GenerateReservationPdfInvoice::dispatch($reservation);
        // dd($products->first()->pivot);
        // session()->forget("current_branch");
        // dd((new TransformersMoney($products->first()->pivot->price))->formatted());
        // dd($order->products->first()->price);
        $locations = $order->user->addresses()->activeAddress()->first()->location->prevNodes()->get();
        // dd($locations);
        return view("orders::order.invoice", ["order" => $order, "locations" => $locations]);
        // return view("reservations::reservation.invoice", ["reservation" => $reservation, "products" => $products]);

    });
    ###CRUD_PLACEHOLDER###
});
