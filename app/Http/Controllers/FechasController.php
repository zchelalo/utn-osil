<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\fechas;
use App\Models\congresos;
use App\Models\presentaciones;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class FechasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function indexAdmin()
    {
        $congresos = congresos::get();
        $presentaciones = presentaciones::get();

        $fechas = fechas::with(['presentaciones', 'congresos'])->get();
        foreach ($fechas as $fecha) {
            $dia = Carbon::parse($fecha->dia)->dayName;
            $fecha['dia'] = ucfirst($dia . ' ' . Carbon::parse($fecha->dia)->format('d-m-Y'));

            $fecha['inicio'] = Carbon::parse($fecha->inicio)->format('H:i');
            $fecha['fin'] = Carbon::parse($fecha->fin)->format('H:i');
        }

        return view('admin.fechas.index', ['fechas' => $fechas, 'congresos' => $congresos, 'presentaciones' => $presentaciones]);
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
        $data = $request->validate([
            'dia' => ['required', 'date'],
            'inicio' => ['required', 'date_format:H:i'],
            'fin' => ['required', 'date_format:H:i', 'after:inicio'],
            'presentacion' => ['required', 'integer'],
            'congreso' => ['nullable', 'integer'],
        ]);

        $fecha = new fechas();

        $fecha->dia = $data['dia'];
        $fecha->inicio = $data['inicio'];
        $fecha->fin = $data['fin'];

        $fechaActual = now();
        $fecha->activo = $fechaActual < $data['dia'] ? true : false;

        $fecha->id_presentacion = $data['presentacion'];
        $fecha->id_congreso = $data['congreso'] > 0 ? $data['congreso'] : null;

        $fecha->save();

        session()->flash('status', 'Fecha añadida');
        session()->flash('icon', 'success');

        return to_route('admin.fechas');
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
    public function edit(fechas $fecha)
    {
        $congresos = congresos::get();
        $presentaciones = presentaciones::get();

        $fecha->inicio = Carbon::parse($fecha->inicio)->format('H:i');
        $fecha->fin = Carbon::parse($fecha->fin)->format('H:i');

        return view('admin.fechas.edit', ['fecha' => $fecha, 'congresos' => $congresos, 'presentaciones' => $presentaciones]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, fechas $fecha)
    {
        $data = $request->validate([
            'dia' => ['required', 'date'],
            'inicio' => ['required', 'date_format:H:i'],
            'fin' => ['required', 'date_format:H:i', 'after:inicio'],
            'presentacion' => ['required', 'integer'],
            'congreso' => ['nullable', 'integer'],
        ]);

        $fechaActual = now();

        $fecha->update([
            'dia' => $data['dia'],
            'inicio' => $data['inicio'],
            'fin' => $data['fin'],
            // 'activo' => $fechaActual < $data['dia'] ? true : false,
            'id_presentacion' => $data['presentacion'],
            'id_congreso' => $data['congreso'] > 0 ? $data['congreso'] : null
        ]);

        session()->flash('status', 'Fecha actualizada');
        session()->flash('icon', 'success');

        return to_route('admin.fechas');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(fechas $fecha)
    {
        $fecha->delete($fecha);

        session()->flash('status', 'Fecha eliminada');
        session()->flash('icon', 'info');
        return to_route('admin.fechas');
    }
}
