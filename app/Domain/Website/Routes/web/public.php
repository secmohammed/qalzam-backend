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
Route::get('/menu', 'PagesController@branches')->name('website.branches');
Route::get('/our_branches', 'PagesController@ourBranches')->name('website.our.branches');
Route::get('/menu/{branch}', 'PagesController@branch')->name('website.branch');
Route::get('/product/{product}', 'PagesController@showProduct')->middleware(['product.has.variations', 'current.branch.available'])->name('website.show.product');
Route::get('/galleries', 'PagesController@galleries')->name('website.galleries');
Route::get('/galleries/{gallery}', 'PagesController@gallery')->name('website.gallery');
//Route::get('/reservation/', 'PagesController@createReservation')->name('website.reservation');
Route::get('/about', 'PagesController@about')->name('website.about');
Route::get('/contact', 'PagesController@contact')->name('website.contact');
Route::get('/terms-and-conditions', 'PagesController@termsAndConditions')->name('website.terms-and-conditions');
Route::get('/policy', 'PagesController@policy')->name('website.policy');
Route::get('/work-with-us', 'EmploymentController@show')->name('website.employment');
Route::post('/work-with-us', 'EmploymentController@store')->name('website.employment.store');
Route::get('/questionnaire', 'QuestionnaireController@show')->name('website.questionnaire');
Route::post('/questionnaire', 'QuestionnaireController@store')->name('website.questionnaire.store');

