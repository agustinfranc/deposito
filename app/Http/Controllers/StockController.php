<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Stock;
use App\Http\Resources\StockResource;
use App\Exports\StockExport;
use Maatwebsite\Excel\Facades\Excel;

class StockController extends Controller
{
    /* public function __construct()
    {
        $this->middleware('auth');
    }
    public function __construct()
    {
        $this->middleware('auth:api');
    } */

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //return DB::table('stocks')->get();
        //return StockResource::collection(Stock::with('ratings')); para usar el resource

        //$usuarioEmail = auth()->user()->email;
        //$stock = Stock::where('usuario', $usuarioEmail)->paginate(10);

        $rubros = DB::table('stocks')
                ->select('rubro')
                ->groupBy('rubro')
                ->get();
        $stock = DB::table('stocks')->get();
        return view('stock.index', compact('stock', 'rubros'));    
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('stock.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $stock = new Stock();
        $stock->codigo = $request->codigo;
        $stock->detalle = $request->detalle;
        $stock->rubro = $request->rubro;
        $stock->precio = $request->precio;

        $stock->usuario_alta = auth()->user()->email;
        $stock->save();

        return back()->with('mensaje', 'Articulo creado');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Stock::where('id', $id)->get();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $stock = Stock::findOrFail($id);
        return view('stock.edit', compact('stock'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $stock = Stock::findOrFail($id);
        $stock->codigo = $request->codigo;
        $stock->detalle = $request->detalle;
        $stock->rubro = $request->rubro;
        $stock->precio = $request->precio;
        $stock->cantidad = $request->cantidad;

        $stock->save();

        return back()->with('mensaje', 'Articulo editado');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $stock = Stock::findOrFail($id);
        $stock->delete();

        return back()->with('mensaje', 'Articulo eliminado');
    }


    public function export()
    {
        return Excel::download(new StockExport, 'stock.xlsx');
    }
}
