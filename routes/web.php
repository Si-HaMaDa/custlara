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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home'); //->middleware('auth.basic');

Route::group(['prefix' => 'panel'], function () {

    Route::get('/', function () {
        return view('admin.index');
    });

    Route::resource('clients', 'ClientController');
});
