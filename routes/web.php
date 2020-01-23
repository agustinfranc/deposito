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
use Illuminate\Support\Facades\DB;

Route::get('/', 'HomeController@index')->name('home');

Auth::routes();

Route::get('/catalogo', function () {
    return view('catalogo');
})->middleware('auth');

//Route::apiResource('/api/stock', 'StockController');
//Route::resource('/api/stock', 'StockController')->middleware('auth');
Route::resource('/stock', 'StockController')->middleware('auth');

/* Route::get('/stock', function () {
    return view('stock');
})->middleware('auth'); */

Route::get('stock/rubro/{rubro}', function ($rubro) {
    $rubros = DB::table('stocks')
        ->select('rubro')
        ->groupBy('rubro')
        ->get();
    $stock = DB::table('stocks')
            ->where('rubro', $rubro)
            ->get();
    return view('stock.index', compact('stock', 'rubros'));    
});