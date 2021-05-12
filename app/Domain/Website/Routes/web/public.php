<?php

use App\Common\Criteria\StatusIsCriteria;
use App\Domain\Product\Criteria\BranchIdCriteria;
use App\Domain\Product\Repositories\Contracts\ProductVariationRepository;
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
Route::get('/branches/{branch}', 'PagesController@branch')->name('website.branch');
Route::get('/galleries', 'PagesController@galleries')->name('website.galleries');
Route::get('/galleries/{gallery}', 'PagesController@gallery')->name('website.gallery');
Route::get('/reservation/', 'PagesController@reservation')->name('website.reservation');
Route::get('/about', 'PagesController@about')->name('website.about');
Route::get('/contact', 'PagesController@contact')->name('website.contact');
Route::get('/terms-and-conditions', 'PagesController@termsAndConditions')->name('website.terms-and-conditions');
Route::get('/policy', 'PagesController@policy')->name('website.policy');
Route::get('/my-cart', 'ProfileController@myCart')->name('website.my-cart');


Route::get('/testing', function (\App\Domain\Product\Entities\ProductVariation $productVariation, ProductVariationRepository $productRepository){
    $productRepository->pushCriteria(new BranchIdCriteria(94));
    $productRepository->pushCriteria(new StatusIsCriteria(true));
    return    $productRepository->with(['branches'])->all();
});
