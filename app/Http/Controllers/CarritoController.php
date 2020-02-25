<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Stock;

class CarritoController extends Controller
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
        $cont = 0;
        $carrito = session('carrito', null);
        if ($carrito) {
            $total = 0;
            foreach ($carrito as $item) {
                if ($item["cantidad"] > 0) {
                    $cont++;
                    $total += $item["precio"] * $item["cantidad"];
                }
            }
            if ($cont > 0)
                return view('carrito.index', compact('carrito', 'total'));
            else
                return view('carrito.index')->with('mensaje', 'error: no existen items en carrito');
        } else {
            return view('carrito.index')->with('mensaje', 'error: no existe carrito');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        $accion = $request->accion;

        $carrito = session('carrito', null);

        if ($carrito && sizeOf($carrito) > 0) {
            foreach ($carrito as $item => $value) {
                if ($value["id"] == $id) {

                    if ($accion == 'agregado') {
                        $carrito[$item]["cantidad"]++;
                    } else if ($carrito[$item]["cantidad"] > 0) {
                        $carrito[$item]["cantidad"]--;
                    }

                    session(['carrito' => $carrito]);
                    return back()->with('mensaje', 'Articulo ' . $accion . ': ' . $value["detalle"]);
                }
            }
            return back()->with('mensaje', 'error: no se encuentra el item');
        } else {
            return back()->with('mensaje', 'error: no existe carrito');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
