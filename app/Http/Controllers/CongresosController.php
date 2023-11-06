<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\congresos;
use App\Models\fechas;
use DateTime;
use Carbon\Carbon;

class CongresosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $congresos = congresos::get();
        // $congresos = congresos::with('organizaciones')->get();
        return view('congresos.index', ['congresos' => $congresos]);
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

        $fechaCongreso = fechas::whereNull('id_taller')->whereNull('id_conferencia')->get();
        $fechasTalleres = fechas::where('id_congreso', $id)->whereNotNull('id_taller')->with('talleres')->get();
        $fechasConferencias = fechas::where('id_congreso', $id)->whereNotNull('id_conferencia')->with('conferencias')->get();

        $fechasEvento = [];
        $fechaInicio = new DateTime($fechaCongreso[0]->dia);
        $fechaFin = new DateTime($fechaCongreso[0]->dia_fin);

        for ($fecha = $fechaInicio; $fecha <= $fechaFin; $fecha->modify('+1 day')) {
            $fechaCarbon = Carbon::parse($fecha);
            $nombreDia = $fechaCarbon->isoFormat('dddd'); // Obtiene el nombre del día en español
            
            $fechasEvento[] = [$fecha->format('Y-m-d'), $nombreDia, $fechaCarbon->format('d-m-Y')];
        }

        foreach ($fechasTalleres as $key => $value) {
            $value->inicio = Carbon::parse($value->inicio)->isoFormat('HH:mm');
            $value->fin = Carbon::parse($value->fin)->isoFormat('HH:mm');
        }

        foreach ($fechasConferencias as $key => $value) {
            $value->inicio = Carbon::parse($value->inicio)->isoFormat('HH:mm');
            $value->fin = Carbon::parse($value->fin)->isoFormat('HH:mm');
        }

        return view('congresos.show', [
            'congreso' => $congreso, 
            'fechasEvento' => $fechasEvento, 
            'fechaCongreso' => $fechaCongreso, 
            'fechasTalleres' => $fechasTalleres, 
            'fechasConferencias' => $fechasConferencias
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
