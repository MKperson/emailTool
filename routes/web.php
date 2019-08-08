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
Route::match(['get', 'post'] ,'/template', 'EmailerController@template')->name('template');
Route::any('/sendEmail', 'EmailerController@sendEmail')->name('reload');


Route::post('/client','EmailerController@client')->name('client');
    


Route::get('fetchtest', function () {
    return view('fetchtest');
});

Auth::routes(['register' => true]);

Route::get('/home', 'HomeController@index')->name('home');

Route::get('login/gitlab', 'Auth\LoginController@redirectToProvider');
Route::get('login/gitlab/callback', 'Auth\LoginController@handleProviderCallback');

