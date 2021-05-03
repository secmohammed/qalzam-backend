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
    Route::apiResource('/discounts', 'DiscountController')->except('index', 'show');
    Route::get('/branches/{branch}/discount/validate', 'DiscountUserController@validateCoupon')->name("discount.validate");
    Route::post('/user_discounts', 'DiscountUserController@store')->name('discounts.purchase');
    ###CRUD_PLACEHOLDER###
});
