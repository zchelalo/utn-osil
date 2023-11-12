<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\congresos;
use App\Models\fechas;
use Carbon\Carbon;

class WelcomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Carbon::setLocale('es');

        $congresos = congresos::where('activo', 0)->orderBy('id')->get();

        foreach ($congresos as $congreso) {
            // Fecha actual
            $fechaActual = Carbon::now();

            $fechaFin = fechas::where('id_congreso', $congreso->id)
                ->orderBy('dia', 'desc')
                ->orderBy('fin', 'desc')
                ->first('dia');

            if (isset($fechaFin->dia))
            {
                // Calcula la diferencia en días
                $diasPasados = $fechaActual->diffInDays(Carbon::parse($fechaFin->dia));

                $congreso['dias_pasados'] = $diasPasados;
            }
        }

        return view('welcome', ['congresos' => $congresos]);
    }

    public function indexAdmin()
    {
        return view('admin.welcome');
    }
}
