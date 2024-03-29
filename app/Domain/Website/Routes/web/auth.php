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
    Route::get('/profile', 'ProfileController@profile')->name('website.profile');
    Route::get('/reservations/website/create', 'PagesController@createReservation')->name('website.reservations.create');
    Route::get('/reservation', 'PagesController@createReservation')->name('website.reservation');

    Route::middleware(['cart.not.empty'])->group(function (){
        Route::get('/my-cart', 'ProfileController@myCart')->name('website.my-cart');
        Route::get('/finish-order', 'ProfileController@finishOrder')->name('website.finish-order');
    });
    ###CRUD_PLACEHOLDER###
});
