<?php

namespace App\Http\Controllers;

use App\Pedido;
use App\DetallePedido;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PedidosController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $email = auth()->user()->email;

        $pedidos = DB::table('pedidos')
            ->where('email', $email)
            ->get();
        return view('pedidos.index', compact('pedidos'));    
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
        $pedido = new Pedido();
        
        $total = 0;
        $carrito = session('carrito', null);

        if ($carrito)
        {
            $pedido->email = auth()->user()->email;
            $pedido->nota = $request->nota;
            $pedido->total = $request->total;
            $pedido->fecha = date("Y-m-d");
            $pedido->save();
            $id = $pedido->id;
            
            foreach ($carrito as $item) {
                if ($item["cantidad"] > 0) {
                    $precio = $item["precio"] * $item["cantidad"];
                    $total += $precio;
                    
                    $detalle_pedido = new DetallePedido();
                    $detalle_pedido->id_pedido = $id;
                    $detalle_pedido->codigo = $item["codigo"];
                    $detalle_pedido->detalle = $item["detalle"];
                    $detalle_pedido->cantidad = $item["cantidad"];
                    $detalle_pedido->precio = $precio;
                    
                    $detalle_pedido->save();
                }
            }
        }
        

        return back()->with('mensaje', 'Pedido creado');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Pedido  $pedidos
     * @return \Illuminate\Http\Response
     */
    public function show(Pedido $pedidos)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Pedido  $pedidos
     * @return \Illuminate\Http\Response
     */
    public function edit(Pedido $pedidos)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Pedido  $pedidos
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Pedido $pedidos)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Pedido  $pedidos
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pedido $pedidos)
    {
        //
    }
}
