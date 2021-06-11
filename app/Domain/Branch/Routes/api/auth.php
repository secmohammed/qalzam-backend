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
    Route::apiResource('/branches', 'BranchController')->except(['index', 'show']);
    Route::put('branch_products/{branch}/update', 'BranchProductController@update')->name('branch.products.update');

    Route::post('branch_products/{branch}', 'BranchProductController@store')->name('branch.products.store');
    Route::apiResource('/albums', 'AlbumController')->except(['index', 'show']);
    Route::resource('/branch_shifts', 'BranchShiftController');
    ###CRUD_PLACEHOLDER###
});
