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
    Route::resource('/branches', 'BranchController');
    Route::get('branch_products/create', 'BranchProductController@create')->name('branch_products.create');
    Route::get('branch_products/{branch}/edit', 'BranchProductController@edit');

    Route::resource('/albums', 'AlbumController');
    Route::resource('/branch_shifts', 'BranchShiftController');
    ###CRUD_PLACEHOLDER###
});
