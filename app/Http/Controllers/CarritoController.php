<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Stock;

class CarritoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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

        if ($carrito) {
            foreach ($carrito as $item => $value) {
                if ($value["id"] == $id) {

                    if ($accion == 'agregado')
                        $carrito[$item]["cantidad"]++;
                    else if ($carrito[$item]["cantidad"] > 0)
                        $carrito[$item]["cantidad"]--;
                    
                    session(['carrito' => $carrito]);
                    return back()->with('mensaje', 'Articulo ' . $accion . ': ' . $value["detalle"]);
                }
            }
            return back()->with('mensaje', 'error: no se encuentra el item');
        }
        else {
            return back()->with('mensaje', 'error: no existe carrito');
        }

        /* if ($accion == "agregar") {
        }
        else {

        }

        $stock->codigo;
        $stock->detalle;
        $stock->rubro;
        $stock->precio;
        $stock->cantidad; */



        //return back()->with('mensaje', 'Articulo agregado');
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
