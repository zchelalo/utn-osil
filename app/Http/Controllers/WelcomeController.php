<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
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

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
