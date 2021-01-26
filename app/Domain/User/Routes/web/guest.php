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

Route::middleware(['guest'])->group(function () {

    Route::get('/forget_password', 'Auth\ForgotPasswordController@forgetPassword')->name('password.request');

    Route::post('/forget_password', 'Auth\ForgotPasswordController')->name('password.email');
    Route::get('/password/reset/{token}', 'Auth\ResetPasswordController@resetPassword')->name('reset_password');
    Route::put('reset-password/{resetToken}', 'Auth\ResetPasswordController@update')->name('auth.reset-password');
});
