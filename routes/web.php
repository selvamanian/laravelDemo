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
// route to show home page
Route::get('/', array('uses' => 'HomeController@home'));

// route to process the form
Route::post('search', array('uses' => 'HomeController@getSearch'));
Route::get('loadmore', array('uses' => 'HomeController@getMore'));
