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
    Route::resource('/posts','PostController')->except('index');
    Route::get('/posts','PostController@dataTable')->name('posts.index');
	###CRUD_PLACEHOLDER###
});
