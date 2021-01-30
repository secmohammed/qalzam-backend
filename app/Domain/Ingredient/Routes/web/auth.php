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
    Route::resource('/ingredients', 'IngredientController');
    Route::post('/ingredients/{ingredient}/products', 'IngredientProductController@store')->name('ingredients.products.store');
    Route::get('/ingredients/{ingredient}/products', 'IngredientProductController@create')->name('ingredients.products.create');
    ###CRUD_PLACEHOLDER###
});
