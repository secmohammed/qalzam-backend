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
    Route::resource('/discounts','DiscountController')->except('index');
    Route::get('/discounts','DiscountController@dataTable')->name('discounts.index');
    Route::delete('/discounts', 'DiscountController@deleteAll')->name('discounts.delete-all');
	
    ###CRUD_PLACEHOLDER###
});
