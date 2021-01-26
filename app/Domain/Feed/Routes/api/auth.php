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
    Route::resource('/feeds', 'FeedController');
    Route::apiResource('feeds.reviews', 'FeedReviewsController')->only('store', 'destroy', 'update');
    Route::apiResource('feeds.comments', 'FeedCommentsController')->except('index', 'show');

    ###CRUD_PLACEHOLDER###
});
