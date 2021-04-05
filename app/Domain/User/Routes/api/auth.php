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
    Route::post('/branches/{branch}/cart', 'CartController@store')->name('auth.cart.store');
    Route::get('/branches/{branch}/cart', 'CartController@index')->name('auth.cart.index');
    Route::put('/branches/{branch}/cart/{productVariation}', 'CartController@update')->name('auth.cart.update');
    Route::delete('/branches/{branch}/cart/{productVariation}', 'CartController@destroy')->name('auth.cart.destroy');
    Route::post('/branches/{branch}/wishlist', 'WishlistController@store')->name('auth.wishlist.store');
    Route::get('/branches/{branch}/wishlist', 'WishlistController@index')->name('auth.wishlist.index');
    Route::put('branches/{branch}/wishlist/{productVariation}', 'WishlistController@update')->name('auth.wishlist.update');
    Route::delete('branches/{branch}/wishlist/{productVariation}', 'WishlistController@destroy')->name('auth.wishlist.destroy');
    Route::resource('/users', 'UserController')->only(['store', 'show', 'update', 'destroy']);
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
Route::get('user/address', 'AddressController@userAddresses')->name('user.addresses');

Route::put('auth/refresh', 'Auth\RefreshJWTTokenController@update')->name('auth.token.refresh');
