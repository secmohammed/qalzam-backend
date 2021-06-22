<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
 */

Route::group(['middleware' => 'auth.api'], function () {
    Route::apiResource('/user_orders', 'UserOrderController')->parameters([
        'user_order' => 'order',
    ]);
    Route::put('orders/{order}/update_status', 'OrderController@updateStatus')->name('orders.update_status');
    
    Route::apiResource('orders', 'OrderController');
    Route::get('deliverer/orders', 'DeliveryOrderController@delivererOrders')->name('deliverer.orders');
    Route::resource('/delivery_orders', 'DeliveryOrderController');
    ###CRUD_PLACEHOLDER###
});
