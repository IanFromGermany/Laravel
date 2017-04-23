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

//mapping the home page
Route::get('/', 'ListController@index');
Route::get('/about', 'ListController@about');

//mapping RESTful routes for lists and tasks- creating resources
Route::resource('list', 'ListController');
Route::resource('todo', 'TodoController');
Route::resource('admin', 'AdminController');

//mapping a route for using a dynamic ID that is passed thru the URL
Route::get('/list/show/{id}', 'ListController@show');
Route::get('/list/delete/{id}', 'ListController@delete');
Route::get('/list/export/{id}', 'ListController@export');
Route::get('/list/archive/{id}', 'ListController@archive');
Route::get('/list/edit/{id}', 'ListController@edit');
Route::post('/list/update', 'ListController@update');

Route::get('/todo/edit/{id}', 'TodoController@edit');
Route::post('/todo/update', 'TodoController@update');
Route::get('/todo/delete/{id}', 'TodoController@delete');

Auth::routes();

Route::get('/home', 'ListController@index');
Route::get('/logout', 'Auth\LoginController@logout');

Route::group(['namespace' => 'Admin', 'prefix' => 'admin'], function() {
    Route::get('/','AdminController@index');

});
