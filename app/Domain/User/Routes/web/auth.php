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
    Route::resource('/users', 'UserController')->except('index');
    Route::get('/users', 'UserController@dataTable')->name('users.index');
    Route::delete('/users', 'UserController@deleteAll')->name('users.delete-all');
    Route::resource('/roles', 'RoleController')->except('index');
    Route::resource('/user/orders', 'RoleController')->except('index');
    Route::get('/roles', 'RoleController@dataTable')->name('roles.index');
    Route::post('logout', 'Auth\LoginController@logout')->name('logout');
    Route::get('notifications', 'NotificationController@index')->name('notifications.index');

    Route::put('notifications/{notification?}', 'NotificationController@update')->name('notifications.update');

    Route::get('change-password', 'Auth\ChangePasswordController@changePasswordForm')->name('change_password');
    Route::put('change-password', 'Auth\ChangePasswordController@update')->name('change_password.update');

    Route::resource('/addresses', 'AddressController')->except('index');
    Route::get('/addresses', 'AddressController@datTable')->name('addresses.index');
    Route::delete('/roles/delete/all', 'RoleController@deleteAll')->name('roles.delete-all');
    Route::delete('/addresses/delete/all', 'AddressController@deleteAll')->name('addresses.delete-all');



    Route::get('/cartTest','CartController@testCart');




});
