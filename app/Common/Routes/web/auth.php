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
        return view("welcome", ["order" => Order::first()]);
    });
    ###CRUD_PLACEHOLDER###
});
