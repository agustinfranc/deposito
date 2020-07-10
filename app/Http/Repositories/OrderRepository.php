<?php

namespace App\Http\Repositories;

use App\Order;
use Illuminate\Support\Facades\DB;

class OrderRepository
{
    public function getOrders($request) {
        return Order::join('users', 'orders.user_id', '=', 'users.id')
        ->select(
            'orders.id'
            , 'orders.user_id'
            , 'orders.note'
            , 'orders.status_id'
            , 'orders.created_at'
            , 'orders.updated_at'
            , 'users.email'
            , 'users.name'
            , DB::raw('(SELECT SUM(price) FROM order_details _order_details WHERE _order_details.order_id = orders.id) total')
        )
        ->when(!auth()->user()->administrator, function ($query) use ($request) {
            return $query->where('user_id', auth()->user()->id);
        })
        ->get();
    }

    public function getOrder($request, $order = null) {
        if(!$order) return;

        $detail = DB::table('order_details')
            ->where('order_id', $order->id)
            ->get();

        $order = Order::join('users', 'orders.user_id', '=', 'users.id')
            ->join('order_statuses', 'orders.status_id', '=', 'order_statuses.id')
            ->select(
                'orders.id'
                , 'orders.user_id'
                , 'orders.note'
                , 'orders.status_id'
                , 'orders.created_at'
                , 'orders.updated_at'
                , 'users.email'
                , 'order_statuses.status'
                , DB::raw('(SELECT SUM(price) FROM order_details _order_details WHERE _order_details.order_id = orders.id) total')
            )
            ->where('orders.id', $order->id)
            ->get()[0];

        return ['order' => $order, 'detail' => $detail];

    }
}