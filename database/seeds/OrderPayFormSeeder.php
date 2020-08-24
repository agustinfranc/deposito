<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrderPayFormSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('order_pay_forms')->insert([
            ['id' => 1, 'name' => 'Efectivo'],
            ['id' => 2, 'name' => 'Cheque'],
        ]);
    }
}
