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

//$namespacePrefix = '\\'.config('voyager.controllers.namespace').'\\';

Route::get('/', function () {
    return view('welcome');
});


Route::group(['prefix' => 'admin', 'middleware' => 'auth.lock'], function () {
    Voyager::routes();
});

// Menu Routes
Route::group([
    'as'     => 'projectpages.',
    'prefix' => 'projectpages/{projectpage}',
], function () {
    Route::get('builder', ['uses' => 'ProjectpagesController@builder',    'as' => 'builder']);
    Route::post('order', ['uses' => 'ProjectpagesController@order_item', 'as' => 'order']);

    Route::group([
        'as'     => 'item.',
        'prefix' => 'item',
    ], function () {
        Route::delete('{id}', ['uses' => 'ProjectpagesController@delete_menu', 'as' => 'destroy']);
        Route::post('/', ['uses' => 'ProjectpagesController@add_item',    'as' => 'add']);
        Route::put('/', ['uses' => 'ProjectpagesController@update_item', 'as' => 'update']);
    });
});

Auth::routes(['register' => false]);

Route::get('/home', 'HomeController@index')->name('home')->middleware('auth','auth.lock');
Route::get('login/locked', 'Auth\LoginController@locked')->middleware('auth')->name('login.locked');
Route::post('login/locked', 'Auth\LoginController@unlock')->name('login.unlock');
//Route::get('/dashboard/brave/overview', 'HomeController@dashboard')->name('Overview');
//Route::get('/dashboard/brave-two/overview', 'PageController@show')->name('Overview');
Route::get('{slug}', 'PageController@show')->where('slug', '([A-Za-z0-9\-\/]+)')->name('Dashboard')->middleware('auth','auth.lock');
Route::get('lang/{locale}', 'LocalizationController@index')->name('language');
