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

use App\Mail\WelcomeMail;

Auth::routes(['verify' => true]);
//Auth::routes(['register' => false]);

Route::get('/', 'HomeController@index')->name('home');

Route::resources([
    'stock' => 'StockController',
    'carrito' => 'CarritoController',
    'pedidos' => 'PedidosController'
]);

Route::get('stock/rubro/{rubro}', 'StockController@getStockPorRubro');

Route::get('exportar/stock', 'StockController@export');

Route::get('email/welcome', function() {
    return new WelcomeMail();
});