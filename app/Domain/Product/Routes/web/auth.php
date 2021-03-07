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
    Route::resource('/products', 'ProductController');
    Route::resource('/product_variations', 'ProductVariationController');
    Route::resource('/product_variation_types', 'ProductVariationTypeController');
    Route::resource('/stocks','StockController');
	Route::resource('/templates','TemplateController');
	###CRUD_PLACEHOLDER###
});
