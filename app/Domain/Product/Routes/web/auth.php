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

Route::middleware(['auth'])->prefix(config('qalzam.dashboard-prefix'))->prefix(config('qalzam.dashboard-prefix'))->group(function () {
    Route::resource('/products', 'ProductController')->except('index');
    Route::get('/products', 'ProductController@datatable')->name('products.index');
    Route::resource('/product_variations', 'ProductVariationController')->except('index');
    Route::get('/product_variations', 'ProductVariationController@datatable')->name('product_variations.index');
    Route::resource('/product_variation_types', 'ProductVariationTypeController')->except('index');
    Route::get('/product_variation_types', 'ProductVariationTypeController@datatable')->name('product_variation_types.index');
    Route::resource('/stocks', 'StockController')->except('index');
    Route::get('/stocks', 'StockController@datatable')->name('stocks.index');
    Route::resource('/templates', 'TemplateController')->except('index');
    Route::get('/templates', 'TemplateController@datatable')->name('templates.index');
    Route::get('/templates/{template}/products', 'TemplateProductController@create')->name("template_product.create");
    Route::delete('/product_variations/delete/all', 'ProductVariationController@deleteAll')->name('product_variations.delete-all');
    Route::delete('/products/delete/all', 'ProductController@deleteAll')->name('products.delete-all');
    Route::delete('/stocks/delete/all', 'StockController@deleteAll')->name('stocks.delete-all');
    Route::delete('/templates/delete/all', 'TemplateController@deleteAll')->name('templates.delete-all');
    Route::delete('/product_variation_types/delete/all', 'ProductVariationTypeController@deleteAll')->name('product_variation_types.delete-all');
    Route::get('template_products/{template}/edit', 'TemplateProductController@edit')->name('template_products.edit');
   
    ###CRUD_PLACEHOLDER###
});
