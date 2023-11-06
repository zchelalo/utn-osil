<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class tipo_presentacion_seeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Verificar si ya existen registros en la tabla 'tipo_presentaciones'
        if (DB::table('tipo_presentaciones')->count() === 0) {
            DB::table('tipo_presentaciones')->insert([
                ['nombre' => 'Taller'],
                ['nombre' => 'Conferencia'],
                ['nombre' => 'Otro'],
            ]);
        }
    }
}
