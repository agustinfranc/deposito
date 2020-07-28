<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrderStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('order_statuses')->insert(['id' => 1, 'status' => 'Iniciado']);

        DB::table('order_statuses')->insert(['id' => 2, 'status' => 'Confirmado']);

        DB::table('order_statuses')->insert(['id' => 3, 'status' => 'Facturado']);

        DB::table('order_statuses')->insert(['id' => 4, 'status' => 'Cobrado']);

        DB::table('order_statuses')->insert(['id' => 5, 'status' => 'Enviado']);

        DB::table('order_statuses')->insert(['id' => 6, 'status' => 'Recibido']);

        DB::table('order_statuses')->insert(['id' => 7, 'status' => 'Cancelado']);
    }
}