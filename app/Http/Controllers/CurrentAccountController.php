<?php

namespace App\Http\Controllers;

use App\Order;
use App\Http\Repositories\OrderRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CurrentAccountController extends Controller
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
        abort(404);

        $orders = $repository->getCurrentAccount(request()->all());

        logger($orders);

        return view('current-account.index', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('current-account.create');
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
     * @param  \App\Order  $orders
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order, OrderRepository $repository)
    {
        $data = $repository->getOrder(request()->all(), $order);

        $order = $data['order'];
        $detail = $data['detail'];

        return view('current-account.show', compact('order', 'detail'));
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
        return view('current-account.edit', compact('order'));
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
