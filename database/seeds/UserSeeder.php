<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'name' => 'Admin',
                'email' => 'admin@prueba.com',
                'cuit' => '87654321',
                'razon' => 'Razon',
                'address' => 'Av Libertador 3000',
                'phone' => '12345678',
                'password' => Hash::make('12345678'),
                'administrator' => 1,
                'remember_token' => Str::random(10),
            ],
            [
                'name' => 'Cliente Prueba',
                'email' => 'cliente@prueba.com',
                'cuit' => '12345678',
                'razon' => 'Maricel',
                'address' => 'Av Cabildo 2500',
                'phone' => '12345678',
                'password' => Hash::make('12345678'),
                'administrator' => 0,
                'remember_token' => Str::random(10),
            ]
        ]);
    }
}
