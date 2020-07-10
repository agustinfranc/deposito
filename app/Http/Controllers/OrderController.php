<?php

namespace App\Http\Controllers;

use App\Order;
use App\OrderDetail;
use App\Http\Repositories\OrderRepository;
use App\Mail\SolicitudPedidoMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class OrderController extends Controller
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
    public function index(OrderRepository $repository)
    {
        $orders = $repository->getOrders(request()->all());

        //logger($orders);

        return view('orders.index', compact('orders'));
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
        $order = new Order();

        $carrito = session('carrito', null);

        if ($carrito)
        {
            $order->user_id = auth()->user()->id;
            $order->note = $request->nota;
            $order->save();
            $id = $order->id;

            foreach ($carrito as $item) {
                if ($item["quantity"] > 0) {
                    $price = $item["price"] * $item["quantity"];

                    $detalle_pedido = new OrderDetail();
                    $detalle_pedido->order_id = $id;
                    $detalle_pedido->code = $item["code"];
                    $detalle_pedido->detail = $item["detail"];
                    $detalle_pedido->quantity = $item["quantity"];
                    $detalle_pedido->price = $price;

                    $detalle_pedido->save();
                }
            }

            $request->session()->forget('carrito');

            // Envio email
            /* if (env("APP_ENV", "local") == 'local')
                Mail::to(auth()->user()->email)->send(new SolicitudPedidoMail()); */

        }

        return back()->with('mensaje', 'Pedido creado');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Order  $orders
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order, OrderRepository $repository)
    {
        $data = $repository->getOrder(request()->all(), $order);

        $order = $data['order'];
        $detail = $data['detail'];

        return view('orders.show', compact('order', 'detail'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Order  $orders
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        $order = Order::findOrFail($order->id);
        return view('orders.edit', compact('order'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Order  $orders
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $orders)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Order  $orders
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $orders)
    {
        //
    }
}
