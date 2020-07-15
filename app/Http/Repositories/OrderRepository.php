<?php

namespace App\Http\Repositories;

use App\Order;
use App\User;
use Illuminate\Support\Facades\DB;

class OrderRepository
{
    public function getOrders($request, $grouped = false) {
        return Order::join('users', 'orders.user_id', '=', 'users.id')
            ->join('order_pay_forms', 'orders.pay_form_id', '=', 'order_pay_forms.id')
            ->select(
                'orders.id'
                , 'orders.user_id'
                , 'orders.note'
                , 'orders.status_id'
                , 'orders.created_at'
                , 'orders.updated_at'
                , 'users.email'
                , 'users.name as user_name'
                , 'order_pay_forms.name as pay_form_name'
                , DB::raw('(SELECT SUM(price) FROM order_details _order_details WHERE _order_details.order_id = orders.id) total')
            )
            ->when(!auth()->user()->administrator, function ($query) use ($request) {
                return $query->where('user_id', auth()->user()->id);
            })
            ->when($grouped, function ($query) {
                return $query->groupBy('user_id');
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

    public function getCurrentAccount($request) {
        return User::
            select(
                'users.id'
                , 'users.email'
                , 'users.name as user_name'
                , DB::raw('(SELECT COUNT(id) FROM orders _orders WHERE _orders.user_id = users.id) order_count')
                , DB::raw('(SELECT COUNT(id) FROM orders _orders WHERE _orders.user_id = users.id AND _orders.status_id < 5) pending_order_count')
                , DB::raw('(SELECT
                    SUM((SELECT SUM(price) FROM order_details = _order_details WHERE _order_details.order_id = _orders.id)) total
                    FROM orders _orders
                    WHERE _orders.user_id = users.id) order_total')
                , DB::raw('(SELECT
                    SUM((SELECT SUM(price) FROM order_details = _order_details WHERE _order_details.order_id = _orders.id)) total
                    FROM orders _orders
                    WHERE _orders.user_id = users.id AND _orders.status_id < 5) pending_order_total')
            )
            ->where('users.administrator', '!=', 1)
            ->when(!auth()->user()->administrator, function ($query) use ($request) {
                return $query->where('user_id', auth()->user()->id);
            })
            ->get();

    }
}