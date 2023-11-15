<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\congresos;
use App\Models\fechas;
use App\Models\organizaciones;
use App\Models\presentaciones;
use App\Models\tipo_presentacion;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class CongresosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Establece la configuración regional en español
        Carbon::setLocale('es');
        
        $congresos = congresos::where('activo', 1)->get();

        foreach ($congresos as $congreso) {
            $fechaInicio = fechas::where('id_congreso', $congreso->id)
                ->orderBy('dia', 'asc')
                ->orderBy('inicio', 'asc')
                ->first('dia');

            $fechaFin = fechas::where('id_congreso', $congreso->id)
                ->orderBy('dia', 'desc')
                ->orderBy('fin', 'desc')
                ->first('dia');

            if (isset($fechaInicio->dia) && isset($fechaFin->dia))
            {
                $congreso['fecha_inicio'] = Carbon::parse($fechaInicio->dia)->format('d-m-Y');
                $congreso['fecha_fin'] = Carbon::parse($fechaFin->dia)->format('d-m-Y');
            }
        }

        $presentaciones = presentaciones::whereIn('id', function ($query) {
            $query->select('id_presentacion')
                ->from('fechas')
                ->where('activo', 1)
                ->distinct();
            })
            ->orderBy('numero_vistas', 'desc')
            ->get();
            
        return view('congresos.index', ['congresos' => $congresos, 'presentaciones' => $presentaciones]);
    }

    public function indexAdmin()
    {
        $congresos = congresos::with('organizaciones')->get();
        $organizaciones = organizaciones::get();
        return view('admin.congresos.index', ['congresos' => $congresos, 'organizaciones' => $organizaciones]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre' => ['required', 'string'],
            'descripcion' => ['required', 'string'],
            'activo' => ['nullable', 'boolean'],
            'organizacion' => ['required', 'integer'],
            'img' => ['nullable'],
            'img.*' => ['string', 'regex:/^data:image\/(png|jpeg|jpg|gif);base64,/i'], // Ejemplo de reglas para imágenes en base64
        ]);
        // dd($data['activo']);

        if (!isset($data['activo']) || (isset($data['activo']) && $data['activo'] != 1))
        {
            $data['activo'] = 0;
        }

        $congreso = new congresos();

        if (isset($data['img'][0]))
        {
            $urlsPublicas = [];
            foreach ($data['img'] as $img) {
                $base64Data = explode(',', $img)[1];
                $decodedData = base64_decode($base64Data);

                $dataImg = getimagesizefromstring($decodedData);

                // Generar un nombre único basado en la fecha actual
                $fechaActual = now();
                $extension = image_type_to_extension($dataImg[2], false); // Obtener la extensión según el tipo de imagen
                $nombreArchivo = $fechaActual->format('YmdHis') . uniqid() . '.' . $extension;
                
                $rutaArchivo = 'public/img/slides/' . $nombreArchivo;
                // Usando Storage para guardar la imagen en el disco predeterminado
                Storage::put($rutaArchivo, $decodedData);  

               // Obtener la URL pública del archivo
                $urlPublica = Storage::url($rutaArchivo);

                $urlsPublicas[] = $urlPublica;
            }
            $congreso->img = $urlsPublicas;
        }

        $congreso->nombre = $data['nombre'];
        $congreso->descripcion = $data['descripcion'];
        $congreso->activo = $data['activo'];
        $congreso->id_organizacion = $data['organizacion'];
        $congreso->save();

        session()->flash('status', 'Congreso añadido');
        session()->flash('icon', 'success');

        return to_route('admin.congresos');
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        // Establece la configuración regional en español
        Carbon::setLocale('es');

        $aumentar_num_vistas = congresos::where('id', $id)->increment('numero_vistas');

        if ($aumentar_num_vistas === 0)
        {
            return to_route('inicio')->with(['status' => 'Hubo un error al entrar a congresos', 'icon' => 'error']);
        }

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

        $congreso['fecha_inicio'] = Carbon::parse($fechaInicio->dia)->format('d-m-Y');
        $congreso['fecha_fin'] = Carbon::parse($fechaFin->dia)->format('d-m-Y');

        return view('congresos.show', [
            'congreso' => $congreso,
            'tiposPresentacion' => $tiposPresentacion,
            'datosPorTipo' => $datosPorTipo
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $congreso = congresos::find($id);
        $organizaciones = organizaciones::get();
        return view('admin.congresos.edit', ['congreso' => $congreso, 'organizaciones' => $organizaciones]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, congresos $congreso)
    {
        $data = $request->validate([
            'nombre' => ['required', 'string'],
            'descripcion' => ['required', 'string'],
            'activo' => ['nullable', 'boolean'],
            'organizacion' => ['required', 'integer'],
            'img' => ['nullable'],
            'img.*' => ['string', 'regex:/^data:image\/(png|jpeg|jpg|gif);base64,/i'], // Ejemplo de reglas para imágenes en base64
        ]);
        // dd($data['activo']);

        if (!isset($data['activo']) || (isset($data['activo']) && $data['activo'] != 1))
        {
            $data['activo'] = 0;
        }

        $urlsPublicas = [];
        if (isset($data['img'][0]))
        {
            foreach ($data['img'] as $img) {
                $base64Data = explode(',', $img)[1];
                $decodedData = base64_decode($base64Data);

                $dataImg = getimagesizefromstring($decodedData);

                // Generar un nombre único basado en la fecha actual
                $fechaActual = now();
                $extension = image_type_to_extension($dataImg[2], false); // Obtener la extensión según el tipo de imagen
                $nombreArchivo = $fechaActual->format('YmdHis') . uniqid() . '.' . $extension;
                
                $rutaArchivo = 'public/img/slides/' . $nombreArchivo;
                // Usando Storage para guardar la imagen en el disco predeterminado
                Storage::put($rutaArchivo, $decodedData);  

               // Obtener la URL pública del archivo
                $urlPublica = Storage::url($rutaArchivo);

                $urlsPublicas[] = $urlPublica;
            }
        }

        if (count($urlsPublicas) > 0)
        {
            $congreso->update([
                'nombre' => $data['nombre'],
                'direccion' => $data['descripcion'],
                'activo' => $data['activo'],
                'id_organizacion' => $data['organizacion'],
                'img' => $urlsPublicas
            ]);
        }
        else
        {
            $congreso->update([
                'nombre' => $data['nombre'],
                'direccion' => $data['descripcion'],
                'activo' => $data['activo'],
                'id_organizacion' => $data['organizacion']
            ]);
        }

        session()->flash('status', 'Congreso actualizado');
        session()->flash('icon', 'success');

        return to_route('admin.congresos');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(congresos $congreso)
    {
        $congreso->delete($congreso);

        session()->flash('status', 'Congreso eliminado');
        session()->flash('icon', 'info');
        return to_route('admin.congresos');
    }
}
