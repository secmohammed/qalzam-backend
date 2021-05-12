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
    Route::resource('/reservations', 'ReservationController')->except('index');
    Route::get('/reservations', 'ReservationController@dataTable')->name('reservations.index');
    Route::get('reservations/{reservation}/pdf', 'ReservationController@generatePdf')->name('reservations.pdf');

    Route::get('/inout', 'ReservationController@inout')->name('inout');
    ###CRUD_PLACEHOLDER###
});
