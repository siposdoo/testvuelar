<?php

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
Route::get('/', 'HomeController@index')->where('any', '.*');
Route::get('/administracija', 'SinglePageController@index')->where('any', '.*');
Route::get('/subscribers', 'SinglePageController@subscribers')->where('any', '.*');
Route::post('/vuelogin', 'Auth\LoginController@vuelogin');
Route::get('/vuelogin', 'LoginController@index');
Route::get('/unsubscribe/{email_token}', 'SubscriberController@unsubscribe');
Route::get('/subscribe/{email_token}', 'SubscriberController@subscribe');
Route::get('/logout', 'Auth\LoginController@logout');
 