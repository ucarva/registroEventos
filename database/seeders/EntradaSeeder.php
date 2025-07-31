<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB; // <-- ESTA LÍNEA ES CLAVE

class EntradaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('entradas')->insert([
            ['tipo_entrada' => 'gratis', 'porcentaje_adicional' => 0.00],
            ['tipo_entrada' => 'general', 'porcentaje_adicional' => 15.00],
            ['tipo_entrada' => 'VIP', 'porcentaje_adicional' => 30.00],
        ]);
    }
}
