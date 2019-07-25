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


Route::get('/', 'EmailerController@index')->middleware('auth');
//Route::get('/', function () {
//return view('welcome');
//});
Route::post('/update', 'EmailerController@update')->name('update');
Route::post('/reload', 'EmailerController@reload')->name('reload');
Route::get('/template', 'EmailerController@template')->name('template');

Route::post('client/', function () {
    return view('client');
});

Route::get('fetchtest', function () {
    return view('fetchtest');
});

Auth::routes(['register' => false]);

Route::get('/home', 'HomeController@index')->name('home');
