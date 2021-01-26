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

Route::group(['middleware' => 'auth.api'], function () {
    Route::post('cart', 'CartController@store')->name('auth.cart.store');
    Route::get('cart', 'CartController@index')->name('auth.cart.index');
    Route::put('cart/{productVariation}', 'CartController@update')->name('auth.cart.update');
    Route::delete('cart/{productVariation}', 'CartController@destroy')->name('auth.cart.destroy');
    Route::post('wishlist', 'WishlistController@store')->name('auth.wishlist.store');
    Route::get('wishlist', 'WishlistController@index')->name('auth.wishlist.index');
    Route::put('wishlist/{productVariation}', 'WishlistController@update')->name('auth.wishlist.update');
    Route::delete('wishlist/{productVariation}', 'WishlistController@destroy')->name('auth.wishlist.destroy');
    Route::resource('/users', 'UserController')->only(['store', 'update', 'destroy']);
    Route::get('notifications', 'NotificationController@index')->name('notifications.index');
    Route::put('notifications/{notification?}', 'NotificationController@update')->name('notifications.update');

    Route::group([
        'prefix' => 'auth',
    ], function () {
        Route::post('logout', 'Auth\LoginController@logout')->name('auth.logout');
        Route::put('change-password', 'Auth\ChangePasswordController@update')->name('auth.change-password');
        Route::get('/me', 'Auth\MeController@show')->name('auth.me');
        Route::put('/me', 'Auth\MeController@update')->name('auth.me.update');

    });
    Route::apiResource('/addresses', 'AddressController')->only([
        'store', 'update', 'index', 'destroy',
    ]);
    ###CRUD_PLACEHOLDER###
});

Route::put('auth/refresh', 'Auth\RefreshJWTTokenController@update')->name('auth.token.refresh');
