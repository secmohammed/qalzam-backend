<?php

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

Route::middleware(['auth'])->prefix(config('qalzam.dashboard-prefix'))->group(function () {
    Route::resource('/orders', 'OrderController')->except('index');
    Route::get('/orders', 'OrderController@dataTable')->name('orders.index');
    Route::post('orders/assign/deliverers', 'DeliveryOrderController@assignDeliverer')->name('orders.assign.deliverer');

    Route::resource('/delivery_orders', 'DeliveryOrderController');
    Route::get('orders/{order}/pdf', 'OrderController@generatePdf')->name('orders.pdf');
    Route::delete('/orders/delete/all', 'OrderController@deleteAll')->name('orders.delete-all');

    ###CRUD_PLACEHOLDER###
});
