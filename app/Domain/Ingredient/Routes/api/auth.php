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
    Route::apiResource('/ingredients', 'IngredientController');
    Route::post('/ingredients/{ingredient}/products', 'IngredientProductController@store')->name('ingredients.products.store');

    ###CRUD_PLACEHOLDER###
});
