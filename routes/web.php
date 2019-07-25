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


Route::get('/', 'EmailerController@index');
//Route::get('/', function () {
//return view('welcome');
//});
Route::post('/update', 'EmailerController@update')->name('update');
Route::post('/reload', 'EmailerController@reload')->name('reload');

Route::post('client/', function () {
    return view('client');
});

// Route::get('login', function () {
//     return view('login');
// });

Route::get('fetchtest', function () {
    return view('fetchtest');
});



Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
