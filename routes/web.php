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

use App\Stock;

Auth::routes();
//Auth::routes(['register' => false]);

Route::get('/', 'HomeController@index')->name('home');

Route::resource('/catalogo', 'CatalogoController')->middleware('auth');

//Route::apiResource('/api/stock', 'StockController');
//Route::resource('/api/stock', 'StockController')->middleware('auth');

/* Route::resource('/stock', 'StockController');
Route::resource('/carrito', 'CarritoController')->middleware('auth'); */

Route::resources([
    'stock' => 'StockController',
    'carrito' => 'CarritoController',
    'pedidos' => 'PedidosController'
]);

Route::get('stock/rubro/{rubro}', 'StockController@getStockPorRubro');

Route::get('exportar/stock', 'StockController@export');