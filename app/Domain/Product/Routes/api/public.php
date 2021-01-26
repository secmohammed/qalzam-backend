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

Route::apiResource('/products', 'ProductController')->only('index', 'show');
Route::apiResource('/product_variations', 'ProductVariationController')->only('index', 'show');
Route::apiResource('/product_variation_types', 'ProductVariationTypeController')->only('index', 'show');
Route::apiResource('/stocks', 'StockController')->only('index', 'show');

###CRUD_PLACEHOLDER###
