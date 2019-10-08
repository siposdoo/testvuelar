<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// Cvi citati
Route::get('articles','ArticleController@index');

// Cvi pretplatnici
Route::get('subscribers','SubscriberController@index');

// Jedan citat
Route::get('article/{id}','ArticleController@show');

// Jedan pretplatnik
Route::get('subscriber/{id}','SubscriberController@show');

// Jedan pretplatnik po emailu
Route::get('subscriberbyemail/{email}','SubscriberController@showbyemail');

// Novi citat
Route::post('article','ArticleController@store');


// Novi pretplatnik
Route::post('subscriber','SubscriberController@store');

// Update pretplatnik
Route::put('subscriber','SubscriberController@store');

// Update citat
Route::put('article','ArticleController@store');

// Brisi citat
Route::delete('article/{id}','ArticleController@destroy');


// Brisi pretplatnika
Route::delete('subscriber/{id}','SubscriberController@destroy');


