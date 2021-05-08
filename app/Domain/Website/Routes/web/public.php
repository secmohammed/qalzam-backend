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

###CRUD_PLACEHOLDER###
Route::get('/', 'PagesController@home')->name('website.home');
Route::get('/branches', 'PagesController@branches')->name('website.branches');
Route::get('galleries', 'PagesController@galleries')->name('website.galleries');
Route::get('galleries/{gallery}', 'PagesController@gallery')->name('website.gallery');
