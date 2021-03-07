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
    Route::apiResource('/products', 'ProductController')->except('index', 'show');
    Route::apiResource('/product_variations', 'ProductVariationController')->except('index', 'show');
    Route::apiResource('branches.products', 'BranchProductVariationController')->only('show');
    Route::apiResource('templates.products', 'TemplateProductController')->only('store');
    Route::apiResource('/product_variation_types', 'ProductVariationTypeController')->except('index', 'show');
    Route::apiResource('/stocks', 'StockController')->except('index', 'show');
    Route::resource('/templates', 'TemplateController');
    ###CRUD_PLACEHOLDER###
});
