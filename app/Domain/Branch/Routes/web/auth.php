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

Route::middleware(['auth'])->prefix(config('qalzam.dashboard-prefix'))->group(function () {
    Route::post('branch_products/{branch}', 'BranchProductController@store')->name('branch.products.store');
    Route::get('branch_products', 'BranchProductController@dataTable')->name('branch.products.index');
    Route::delete('branch_products/{branch}/{product}/{product_variation}', 'BranchProductController@destroy')->name('branch.products.delete');
    Route::resource('/branches', 'BranchController')->except('index');
    Route::get('/branches', 'BranchController@dataTable')->name('branches.index');
    Route::get('branch_products/create', 'BranchProductController@create')->name('branch_products.create');
    Route::get('branch_products/{branch}/edit', 'BranchProductController@edit')->name('branch_products.edit');

    Route::resource('/albums', 'AlbumController')->except('index');
    Route::get('/albums', 'AlbumController@dataTable')->name('albums.index');
    Route::resource('/branch_shifts', 'BranchShiftController')->except('index');
    Route::get('/branch_shifts', 'BranchShiftController@dataTable')->name('branch_shifts.index');
    Route::delete('/branch_shifts/delete/all', 'BranchShiftController@deleteAll')->name('branch_shifts.delete-all');
    Route::delete('/branch_products/delete/all', 'BranchProductController@deleteAll')->name('branch_products.delete-all');
    Route::delete('/branches/delete/all', 'BranchController@deleteAll')->name('branches.delete-all');
    Route::delete('/albums/delete/all', 'AlbumController@deleteAll')->name('albums.delete-all');
   

    ###CRUD_PLACEHOLDER###
});
