<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\presentaciones;
use App\Models\tipo_presentacion;
use App\Models\fechas;
use Carbon\Carbon;

class PresentacionesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Establece la configuración regional en español
        Carbon::setLocale('es');

        // $presentaciones = fechas::with(['presentaciones', 'congresos'])->where('activo', 1)->distinct('id_presentacion')->get();
        $presentaciones = fechas::with(['presentaciones', 'congresos'])
            ->join('presentaciones', 'fechas.id_presentacion', '=', 'presentaciones.id')
            ->join('tipo_presentaciones', 'presentaciones.id_tipo_presentacion', '=', 'tipo_presentaciones.id')
            ->where('fechas.activo', 1)
            ->select('tipo_presentaciones.nombre as tipo_presentacion_nombre', 'fechas.*')
            ->orderBy('dia', 'asc')
            ->orderBy('inicio', 'asc')
            ->get();

        foreach ($presentaciones as $presentacion) {
            $presentacion['dia'] = Carbon::parse($presentacion->dia)->format('d-m-Y');
            $presentacion['inicio'] = Carbon::parse($presentacion->inicio)->format('H:i');
            $presentacion['fin'] = Carbon::parse($presentacion->fin)->format('H:i');
        }

        // Ahora, agrupa los resultados por 'id_presentacion' utilizando collections
        $presentacionesAgrupadas = $presentaciones->groupBy('id_presentacion')->all();

        $tiposPresentacion = tipo_presentacion::get();

        return view('presentaciones.index', ['presentaciones' => $presentacionesAgrupadas, 'tipo_presentaciones' => $tiposPresentacion]);
    }

    public function busqueda(Request $request)
    {
        $data = $request->validate([
            'idTipo' => ['nullable', 'integer'],
            'nombrePresentacion' => ['nullable', 'string']
        ]);
        
        // Establece la configuración regional en español
        Carbon::setLocale('es');

        $presentaciones = fechas::with(['presentaciones', 'congresos'])
            ->join('presentaciones', 'fechas.id_presentacion', '=', 'presentaciones.id')
            ->join('tipo_presentaciones', 'presentaciones.id_tipo_presentacion', '=', 'tipo_presentaciones.id')
            ->where('fechas.activo', 1);

        if (isset($data['idTipo']))
        {
            $presentaciones->where('tipo_presentaciones.id', $data['idTipo']);
        }

        if (isset($data['nombrePresentacion']))
        {
            $presentaciones->whereRaw('LOWER(presentaciones.nombre) LIKE ?', ['%' . strtolower($data['nombrePresentacion']) . '%']);
        }

        $presentaciones = $presentaciones
            ->select('tipo_presentaciones.nombre as tipo_presentacion_nombre', 'fechas.*')
            ->orderBy('dia', 'asc')
            ->orderBy('inicio', 'asc')
            ->get();

        foreach ($presentaciones as $presentacion) {
            $presentacion['dia'] = Carbon::parse($presentacion->dia)->format('d-m-Y');
            $presentacion['inicio'] = Carbon::parse($presentacion->inicio)->format('H:i');
            $presentacion['fin'] = Carbon::parse($presentacion->fin)->format('H:i');
        }

        // Ahora, agrupa los resultados por 'id_presentacion' utilizando collections
        $presentacionesAgrupadas = $presentaciones->groupBy('id_presentacion')->all();

        return response()->json($presentacionesAgrupadas);
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

        $aumentar_num_vistas = presentaciones::where('id', $id)->increment('numero_vistas');

        if ($aumentar_num_vistas === 0)
        {
            return to_route('inicio')->with('status', 'Hubo un error al entrar a presentaciones');
        }
        
        // $presentaciones = fechas::with(['presentaciones', 'congresos'])->where('activo', 1)->distinct('id_presentacion')->get();
        $presentaciones = fechas::with(['presentaciones', 'congresos'])
            ->join('presentaciones', 'fechas.id_presentacion', '=', 'presentaciones.id')
            ->join('tipo_presentaciones', 'presentaciones.id_tipo_presentacion', '=', 'tipo_presentaciones.id')
            ->where('presentaciones.id', $id)
            ->select('tipo_presentaciones.nombre as tipo_presentacion_nombre', 'fechas.*')
            ->orderBy('dia', 'asc')
            ->orderBy('inicio', 'asc')
            ->get();

        foreach ($presentaciones as $presentacion) {
            $presentacion['dia'] = Carbon::parse($presentacion->dia)->format('d-m-Y');
            $presentacion['inicio'] = Carbon::parse($presentacion->inicio)->format('H:i');
            $presentacion['fin'] = Carbon::parse($presentacion->fin)->format('H:i');
        }

        return view('presentaciones.show', ['presentaciones' => $presentaciones]);
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
