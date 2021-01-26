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

Route::group(['middleware' => 'guest.api', 'prefix' => 'auth'], function () {
    Route::post('login', 'Auth\LoginController@login')->name('auth.login');
    Route::post('forgot-password', 'Auth\ForgotPasswordController@store')->name('auth.forgot-password');
    Route::put('reset-password/{resetToken}', 'Auth\ResetPasswordController@update')->name('auth.reset-password');
    Route::post('register', 'Auth\RegisterController@store')->name('auth.register');
    Route::get('/verify/{user}/{verifyToken}', 'Auth\VerifyCodeController@show')->name('auth.verify-code');

});
