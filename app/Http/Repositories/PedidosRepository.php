<?php

namespace App\Http\Repositories;

use App\Pedido;
use Illuminate\Support\Facades\DB;

class PedidosRepository
{
    public function getPedidos($request) {
        return Pedido::join('users', 'pedidos.user_id', '=', 'users.id')
        ->select(
            'pedidos.id'
            , 'pedidos.user_id'
            , 'pedidos.note'
            , 'pedidos.state_id'
            , 'pedidos.created_at'
            , 'pedidos.updated_at'
            , 'users.email'
            , 'users.name'
            , DB::raw('(SELECT SUM(price) FROM pedidos_detalle _pedidos_detalle WHERE _pedidos_detalle.pedido_id = pedidos.id) total')
        )
        ->when(!auth()->user()->administrator, function ($query) use ($request) {
            return $query->where('user_id', auth()->user()->id);
        })
        ->get();
    }

    public function getPedido() {
        //
    }
}