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

Route::group(['middleware' =>['auth.basic']], function (){
    Route::get('/', function () {
        return view('index');
    });

    Route::post('/space', 'SpaceController@store')->name('space.create');
});
