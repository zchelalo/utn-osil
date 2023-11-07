<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\congresos;
use App\Models\fechas;
use App\Models\presentaciones;
use App\Models\tipo_presentacion;
use Carbon\Carbon;

class CongresosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $congresos = congresos::get();
        // $presentaciones = fechas::where('activo', 1)->get();
        $presentaciones = fechas::with('presentaciones')->where('activo', 1)->get();
        return view('congresos.index', ['congresos' => $congresos, 'presentaciones' => $presentaciones]);
    }

    public function indexAdmin()
    {
        //
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
    public function show(int $id)
    {
        // Establece la configuración regional en español
        Carbon::setLocale('es');

        $congreso = congresos::with('organizaciones')->find($id);

        $tiposPresentacion = tipo_presentacion::get();

        $presentaciones = presentaciones::where('id_congreso', $id)
            ->with('tipo_presentacion')
            ->get();

        if (!isset($presentaciones[0]))
        {
            return view('congresos.show', [
                'congreso' => $congreso
            ]);
        }

        $datosPorTipo = [];

        foreach ($presentaciones as $presentacion) {
            $tipoPresentacion = $presentacion->tipo_presentacion;
            $nombreTipo = $tipoPresentacion->nombre; // Nombre del tipo de presentación

            if (!isset($datosPorTipo[$nombreTipo])) {
                $datosPorTipo[$nombreTipo] = [];
            }

            $datosPorTipo[$nombreTipo][] = $presentacion;
        }
        // dd($datosPorTipo);

        $fechaInicio = fechas::where('id_congreso', $id)
            ->orderBy('dia', 'asc')
            ->orderBy('inicio', 'asc')
            ->first('dia');

        $fechaFin = fechas::where('id_congreso', $id)
            ->orderBy('dia', 'desc')
            ->orderBy('fin', 'desc')
            ->first('dia');

        $fechaCongreso = Carbon::parse($fechaInicio->dia)->format('d-m-Y') . ' - ' . Carbon::parse($fechaFin->dia)->format('d-m-Y');

        return view('congresos.show', [
            'congreso' => $congreso,
            'fechaCongreso' => $fechaCongreso,
            'tiposPresentacion' => $tiposPresentacion,
            'datosPorTipo' => $datosPorTipo
        ]);
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
