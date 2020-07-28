<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StockSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('stocks')->insert([
            'rubro' => 'Carniceria',
            'code' => 1,
            'detail' => 'Lomo',
            'quantity' => 3,
            'price' => 500,
            'creator_id' => 1,
        ]);
    }
}
