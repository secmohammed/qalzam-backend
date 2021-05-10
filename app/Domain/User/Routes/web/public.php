<?php

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

Route::get('/', function () {
    return view('theme.app');
})->prefix(config('qalzam.dashboard-prefix'));

Route::get('login', 'Auth\LoginController@showLoginForm')->prefix(config('qalzam.dashboard-prefix'))->name('login');
Route::post('login', 'Auth\LoginController@login')->name('auth.login');

Route::post('/reset_password/{token}', 'Auth\ResetPasswordController@resetPassword')->name('reset_password');
