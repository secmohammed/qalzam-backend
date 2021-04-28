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


Route::middleware(['auth'])->group(function () {
    Route::resource('/discounts','DiscountController')->except('index');
    Route::get('/discounts','DiscountController@dataTable')->name('discounts.index');
	###CRUD_PLACEHOLDER###
});
