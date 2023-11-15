<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\fechas;
use App\Models\congresos;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class FechasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function horarioPdf(int $id)
    {
        // Establece la configuración regional en español
        Carbon::setLocale('es');

        $congreso = congresos::find($id);

        $fechas = fechas::with(['presentaciones'])
            ->where('id_congreso', $id)
            ->orderBy('dia', 'asc')
            ->orderBy('inicio', 'asc')
            ->get();

        foreach ($fechas as $fecha) {
            $dia = Carbon::parse($fecha->dia)->dayName;
            $fecha->dia = ucfirst($dia . ' ' . Carbon::parse($fecha->dia)->format('d-m-Y'));

            $fecha->inicio = Carbon::parse($fecha->inicio)->format('H:i');
            $fecha->fin = Carbon::parse($fecha->fin)->format('H:i');
        }

        $fechasAgrupadas = $fechas->groupBy('dia')->all();
        foreach ($fechasAgrupadas as $clave => $fecha) {
            $inicioAnterior = null;
            $finAnterior = null;
            $nuevoArray = [];
        
            foreach ($fecha as $presentacion) {
                if ($presentacion->inicio == $inicioAnterior && $presentacion->fin == $finAnterior) {
                    // Presentación duplicada, agregar al array anterior
                    array_push($nuevoArray[count($nuevoArray) - 1], $presentacion);
                } else {
                    // Nueva presentación, agregar al nuevo array
                    $nuevoArray[] = [$presentacion];
                    $inicioAnterior = $presentacion->inicio;
                    $finAnterior = $presentacion->fin;
                }
            }
        
            // Asignar el nuevo array a la clave
            $fechasAgrupadas[$clave] = $nuevoArray;
        }
        // dd($fechasAgrupadas);

        $pdf = Pdf::loadView('pdf_layouts.horario', ['fechas' => $fechasAgrupadas, 'congreso' => $congreso]);
        return $pdf->download('horario.pdf');
        // return $pdf->stream();
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
