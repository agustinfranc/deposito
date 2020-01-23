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

/* Route::get('/', function () {
    return view('home');
})->middleware('auth'); */

Route::get('/', 'HomeController@index')->name('home');

Auth::routes();

Route::get('/catalogo', function () {
    return view('catalogo');
})->middleware('auth');

//Route::apiResource('/api/stock', 'StockController');
Route::resource('/api/stock', 'StockController')->middleware('auth');

Route::get('/stock', function () {
    return view('stock');
})->middleware('auth');