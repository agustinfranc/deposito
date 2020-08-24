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

use Illuminate\Support\Facades\Route;
use App\Mail\OrderConfirmed;
use App\Mail\WelcomeMail;
use Illuminate\Support\Facades\Auth;

/* Route::get('/', function () {
    return view('home');
})->middleware('auth'); */

Auth::routes(['verify' => true]);
//Auth::routes(['register' => false]);

Route::get('/', 'HomeController@index')->name('home');

Route::get('/temp', 'HomeController@index')->name('temp');

Route::resources([
    'stock' => 'StockController',
    'orders' => 'OrderController',
    'current-account' => 'CurrentAccountController',
    'users' => 'UserController',
]);

Route::get('orders/{id}/state/{state_id}', 'OrderController@updateState')->name('orders.updateState');

Route::get('orders/{order}/remito', 'OrderController@getRemito')->name('orders.remito');

Route::put('carrito/{id}', 'OrderController@updateCarrito')->name('orders.updateCarrito');

Route::get('stock/rubro/{rubro}', 'StockController@getStockPorRubro');

Route::get('exportar/stock', 'StockController@export');