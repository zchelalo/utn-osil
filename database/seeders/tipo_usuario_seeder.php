<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class tipo_usuario_seeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Verificar si ya existen registros en la tabla 'tipo_usuarios'
        if (DB::table('tipo_usuarios')->count() === 0) {
            DB::table('tipo_usuarios')->insert([
                ['descripcion' => 'Invitado'],
                ['descripcion' => 'Tallerista'],
                ['descripcion' => 'Conferencista'],
                ['descripcion' => 'Administrador'],
            ]);
        }
    }
}
