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
    Route::apiResource('/posts', 'PostController')->except('index', 'show');
    Route::apiResource('posts.comments', 'PostCommentsController')->except('index', 'show');
    Route::apiResource('posts.reviews', 'PostReviewsController')->only('store', 'destroy', 'update');
    ###CRUD_PLACEHOLDER###
});
