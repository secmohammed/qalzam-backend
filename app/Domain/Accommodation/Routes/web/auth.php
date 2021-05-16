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
    Route::resource('/accommodations','AccommodationController')->except('index');
    Route::get('/accommodations','AccommodationController@dataTable')->name('accommodations.index');
	Route::resource('/contracts','ContractController')->except('index');
	Route::get('/contracts','ContractController@dataTable')->name('contracts.index');
	###CRUD_PLACEHOLDER###
});
