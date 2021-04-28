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
    Route::resource('/users', 'UserController')->except('index');
    Route::get('/users', 'UserController@dataTable')->name('users.index');
    Route::resource('/roles', 'RoleController');
    Route::post('logout', 'Auth\LoginController@logout')->name('logout');
    Route::get('notifications', 'NotificationController@index')->name('notifications.index');

    Route::put('notifications/{notification?}', 'NotificationController@update')->name('notifications.update');

    Route::get('change-password', 'Auth\ChangePasswordController@changePasswordForm')->name('change_password');
    Route::put('change-password', 'Auth\ChangePasswordController@update')->name('change_password.update');

});
