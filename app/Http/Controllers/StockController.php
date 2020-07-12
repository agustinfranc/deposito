<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App;
use App\Stock;
use App\Http\Resources\StockResource;
use App\Exports\StockExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Auth;

class StockController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /* public function __construct()
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

        $rubros = Stock::select('rubro')
            ->groupBy('rubro')
            ->paginate(20);

        $stock = Stock::paginate(20);


        // TODO: foreach stock chequear si existe en la sesion (carrito) y si existe agregar la quantity

        $total = 0;
        $carrito = session('carrito', null);
        if ($carrito) foreach ($carrito as $item) {
            if ($item["quantity"] > 0)
                $total += $item["price"] * $item["quantity"];
        }

        $array_stock = [];
        foreach ($stock as $item) {

            $item->carrito = 0;

            if ($carrito)
                foreach ($carrito as $key)
                    if ($item->id == $key["id"])
                        $item->carrito = $key["quantity"];

            $array = [
                'id' => $item->id,
                'code' => $item->code,
                'detail' => $item->detail,
                'rubro' => $item->rubro,
                'price' => $item->price,
                'quantity' => 0
            ];
            array_push($array_stock, $array);
        }

        if (!session()->has('carrito')) {
            session(['carrito' => $array_stock]);
        }

        return view('stock.index', compact('stock', 'rubros', 'carrito', 'total'));
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
        $stock->code = $request->code;
        $stock->detail = $request->detail;
        $stock->rubro = $request->rubro;
        $stock->price = $request->price;
        $stock->creator_id = auth()->user()->id;
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
        $stock->code = $request->code;
        $stock->detail = $request->detail;
        $stock->rubro = $request->rubro;
        $stock->price = $request->price;
        $stock->quantity = $request->quantity;

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


    public function getStockPorRubro($rubro)
    {
        $rubros = Stock::select('rubro')->groupBy('rubro')->paginate(10);
        $stock = Stock::where('rubro', $rubro)->paginate(10);

        $total = 0;
        $carrito = session('carrito', null);
        if ($carrito) foreach ($carrito as $item) {
            if ($item["quantity"] > 0)
                $total += $item["price"];
        }

        $array_stock = [];
        foreach ($stock as $item) {

            $item->carrito = 0;

            if ($carrito)
                foreach ($carrito as $key)
                    if ($item->id == $key["id"])
                        $item->carrito = $key["quantity"];

            $array = [
                'id' => $item->id,
                'code' => $item->code,
                'detail' => $item->detail,
                'rubro' => $item->rubro,
                'price' => $item->price,
                'quantity' => 0
            ];
            array_push($array_stock, $array);
        }

        return view('stock.index', compact('stock', 'rubros', 'total'));
    }


    public function export()
    {
        return Excel::download(new StockExport, 'stock.xlsx');
    }
}
