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

// show welcome message
Route::get('/', function () {
    return view('welcome');
});

// login via Google
Route::get('login',array('as'=>'login', 'uses'=>'UserController@login'));

// home
Route::group(['middleware' => ['auth'], 'prefix' => 'home'], function() {

    Route::get('index', ['uses' => 'HomeController@index', 'as' => 'home']);

    Route::get('flow', ['uses' => 'HomeController@flow', 'as' => 'flow']);

    Route::get('stats', ['uses' => 'HomeController@stats', 'as' => 'stats']);

    Route::group(['middleware' => ['diary']], function() {

        Route::get('edit/{diary}', ['uses' => 'HomeController@show', 'as' => 'state.show']);

        Route::put('edit/{diary}', ['uses' => 'HomeController@update', 'as' => 'state.update']);

    });

    Route::get('logout', ['uses' => 'UserController@logout', 'as' => 'logout']);

});
