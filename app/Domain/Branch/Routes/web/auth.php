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
    Route::post('branch_products/{branch}', 'BranchProductController@store')->name('branch.products.store');
    Route::get('branch_products/{branch}/create', 'BranchProductController@create')->name('branch.products.create');
    Route::resource('/branches', 'BranchController');
    Route::resource('/albums', 'AlbumController');
    Route::resource('/branch_shifts', 'BranchShiftController');
    ###CRUD_PLACEHOLDER###
});
