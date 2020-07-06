<?php

namespace App\Http\Controllers;

use App\Pedido;
use App\DetallePedido;
use App\Http\Repositories\PedidosRepository;
use App\Mail\SolicitudPedidoMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

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
    public function index(PedidosRepository $repository)
    {
        $pedidos = $repository->getPedidos(request()->all());

        logger($pedidos);

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

        $carrito = session('carrito', null);

        if ($carrito)
        {
            $pedido->user_id = auth()->user()->id;
            $pedido->note = $request->nota;
            $pedido->save();
            $id = $pedido->id;

            foreach ($carrito as $item) {
                if ($item["quantity"] > 0) {
                    $price = $item["price"] * $item["quantity"];

                    $detalle_pedido = new DetallePedido();
                    $detalle_pedido->pedido_id = $id;
                    $detalle_pedido->code = $item["code"];
                    $detalle_pedido->detail = $item["detail"];
                    $detalle_pedido->quantity = $item["quantity"];
                    $detalle_pedido->price = $price;

                    $detalle_pedido->save();
                }
            }

            $request->session()->forget('carrito');

            // Envio email
            if (env("APP_ENV", "local") == 'local')
                Mail::to(auth()->user()->email)->send(new SolicitudPedidoMail());

        }

        return back()->with('mensaje', 'Pedido creado');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Pedido  $pedidos
     * @return \Illuminate\Http\Response
     */
    public function show(Pedido $pedido)
    {
        $detail = DB::table('pedidos_detalle')
            ->where('pedido_id', $pedido->id)
            ->get();

        $pedido = Pedido::join('users', 'pedidos.user_id', '=', 'users.id')
            ->select(
                'pedidos.id'
                , 'pedidos.user_id'
                , 'pedidos.note'
                , 'pedidos.state_id'
                , 'pedidos.created_at'
                , 'pedidos.updated_at'
                , 'users.email'
                , DB::raw('(SELECT SUM(price) FROM pedidos_detalle _pedidos_detalle WHERE _pedidos_detalle.pedido_id = pedidos.id) total')
            )
            ->where('pedidos.id', $pedido->id)
            ->get()[0];

        return view('pedidos.show', compact('pedido', 'detail'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Pedido  $pedidos
     * @return \Illuminate\Http\Response
     */
    public function edit(Pedido $pedido)
    {
        $pedido = Pedido::findOrFail($pedido->id);
        return view('pedidos.edit', compact('pedido'));
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
