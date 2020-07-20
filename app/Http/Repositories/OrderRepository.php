<?php

namespace App\Http\Repositories;

use App\Order;
use App\User;
use Illuminate\Support\Facades\DB;

class OrderRepository
{
    public function getOrders($request, $grouped = false) {

        $period = isset($request['period']) ? $request['period'] : 'Ultima semana';

        $periods = [
            'Ultima semana' => ['days' => 7, 'operator' => '>='],
            'Ultimo mes' => ['days' => 30, 'operator' => '>='],
            'Ultimo trimestre' => ['days' => 90, 'operator' => '>='],
            'Ultimo semestre' => ['days' => 180, 'operator' => '>='],
            'Ultimo año' => ['days' => 360, 'operator' => '>='],
            'Más de un año' => ['days' => 360, 'operator' => '<'],
        ];

        if(isset($periods[$period])) $createdAtConditional = 'DATE(orders.created_at) ' . $periods[$period]['operator'] . ' DATE_SUB(NOW(), INTERVAL ' . $periods[$period]['days'] . ' DAY)';

        return Order::join('users', 'orders.user_id', '=', 'users.id')
            ->join('order_pay_forms', 'orders.pay_form_id', '=', 'order_pay_forms.id')
            ->select(
                'orders.id'
                , 'orders.user_id'
                , 'orders.note'
                , 'orders.status_id'
                , 'orders.shipping_date'
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
            ->when(auth()->user()->administrator && $request['user_id'], function ($query) use ($request) {
                return $query->where('user_id', $request['user_id']);
            })
            ->when($request['period'], function ($query) use ($request, $createdAtConditional) {
                return $query->whereRaw($createdAtConditional);
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
                , 'orders.shipping_date'
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
        $period = isset($request['period']) ? $request['period'] : 'Ultima semana';

        $periods = [
            'Ultima semana' => ['days' => 7, 'operator' => '>='],
            'Ultimo mes' => ['days' => 30, 'operator' => '>='],
            'Ultimo trimestre' => ['days' => 90, 'operator' => '>='],
            'Ultimo semestre' => ['days' => 180, 'operator' => '>='],
            'Ultimo año' => ['days' => 360, 'operator' => '>='],
            'Más de un año' => ['days' => 360, 'operator' => '<'],
        ];

        if(isset($periods[$period])) $createdAtConditional = 'AND DATE(_orders.created_at) ' . $periods[$period]['operator'] . ' DATE_SUB(NOW(), INTERVAL ' . $periods[$period]['days'] . ' DAY)';

        return User::
            select(
                'users.id'
                , 'users.email'
                , 'users.name as user_name'
                , DB::raw("(SELECT COUNT(id) FROM orders _orders WHERE _orders.user_id = users.id $createdAtConditional) order_count")
                , DB::raw("(SELECT COUNT(id) FROM orders _orders WHERE _orders.user_id = users.id AND _orders.status_id < 5 $createdAtConditional) pending_order_count")
                , DB::raw("(SELECT
                    SUM((SELECT SUM(price) FROM order_details = _order_details WHERE _order_details.order_id = _orders.id)) total
                    FROM orders _orders
                    WHERE _orders.user_id = users.id $createdAtConditional) order_total")
                , DB::raw("(SELECT
                    SUM((SELECT SUM(price) FROM order_details = _order_details WHERE _order_details.order_id = _orders.id)) total
                    FROM orders _orders
                    WHERE _orders.user_id = users.id AND _orders.status_id < 5 $createdAtConditional) pending_order_total")
            )
            ->where('users.administrator', '!=', 1)
            ->when(!auth()->user()->administrator, function ($query) use ($request) {
                return $query->where('users.id', auth()->user()->id);
            })
            ->get();

    }
}