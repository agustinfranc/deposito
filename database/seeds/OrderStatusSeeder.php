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
        DB::table('order_statuses')->insert([
            ['id' => 1, 'status' => 'Iniciado'],
            ['id' => 2, 'status' => 'Confirmado'],
            ['id' => 3, 'status' => 'Facturado'],
            ['id' => 4, 'status' => 'Cobrado'],
            ['id' => 5, 'status' => 'Enviado'],
            ['id' => 6, 'status' => 'Recibido'],
            ['id' => 7, 'status' => 'Cancelado'],
        ]);
    }
}