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


//index
Route::get('/','HeatController@index');

//import data
Route::post('/importDatas','HeatController@import');
//clear db
Route::post('/clearDatas','HeatController@clear');

// search data
Route::post('/search','HeatController@search');
