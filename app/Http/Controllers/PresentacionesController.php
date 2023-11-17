<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\presentaciones;
use App\Models\tipo_presentacion;
use App\Models\fechas;
use App\Models\congresos;
use App\Models\usuarios;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

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

    public function indexAdmin()
    {
        $tipos = tipo_presentacion::get();
        $congresos = congresos::get();
        $usuarios = usuarios::get();
        $presentaciones = presentaciones::with(['tipo_presentacion', 'congresos', 'usuarios'])->get();
        return view('admin.presentaciones.index', ['presentaciones' => $presentaciones, 'tipos' => $tipos, 'congresos' => $congresos, 'usuarios' => $usuarios]);
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
        $data = $request->validate([
            'nombre' => ['required', 'string'],
            'descripcion' => ['required', 'string'],
            'img' => ['nullable', 'string', 'regex:/^data:image\/(png|jpeg|jpg|gif);base64,/i'],
            'presentacion' => ['nullable', 'mimes:pdf', 'max:10000'],
            'tipo' => ['required', 'integer'],
            'congreso' => ['nullable', 'integer'],
            'usuario' => ['required', 'integer'],
        ]);

        $presentacion = new presentaciones();

        if (isset($data['img']))
        {
            $urlPublica = null;
            $base64Data = explode(',', $data['img'])[1];
            $decodedData = base64_decode($base64Data);

            $dataImg = getimagesizefromstring($decodedData);

            // Generar un nombre único basado en la fecha actual
            $fechaActual = now();
            $extension = image_type_to_extension($dataImg[2], false); // Obtener la extensión según el tipo de imagen
            $nombreArchivo = $fechaActual->format('YmdHis') . uniqid() . '.' . $extension;
            
            $rutaArchivo = 'public/img/portadas/' . $nombreArchivo;
            // Usando Storage para guardar la imagen en el disco predeterminado
            Storage::put($rutaArchivo, $decodedData);  

            // Obtener la URL pública del archivo
            $urlPublica = Storage::url($rutaArchivo);

            $presentacion->img = $urlPublica;
        }

        if (isset($data['presentacion']))
        {
            $file = $request->file('presentacion');
            $name = $file->getClientOriginalName();
            $fechaActual = now();

            $nombreArchivo = $fechaActual->format('YmdHis') . uniqid() . $name;
            
            $rutaArchivo = 'public/pdf/presentaciones/' . $nombreArchivo;
            $path = Storage::putFileAs(
                'public/pdf/presentaciones/', $file, $nombreArchivo
            );

            // Obtener la URL pública del archivo
            $urlPublica = Storage::url($rutaArchivo);

            $presentacionPdf = ['pdf' => $urlPublica];
            $presentacion->presentacion = $presentacionPdf;
        }

        if (isset($data['congreso']) && $data['congreso'] != 0)
        {
            $presentacion->id_congreso = $data['congreso'];
        }
        else if($data['congreso'] == 0)
        {
            $presentacion->id_congreso = null;
        }

        $presentacion->nombre = $data['nombre'];
        $presentacion->descripcion = $data['descripcion'];
        $presentacion->numero_vistas = 1;
        $presentacion->id_tipo_presentacion = $data['tipo'];
        $presentacion->id_usuario = $data['usuario'];
        $presentacion->save();

        session()->flash('status', 'Presentación añadida');
        session()->flash('icon', 'success');

        return to_route('admin.presentaciones');
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
    public function edit(presentaciones $presentacion)
    {
        $tipos = tipo_presentacion::get();
        $congresos = congresos::get();
        $usuarios = usuarios::get();
        return view('admin.presentaciones.edit', ['presentacion' => $presentacion, 'tipos' => $tipos, 'congresos' => $congresos, 'usuarios' => $usuarios]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, presentaciones $presentacion)
    {
        $data = $request->validate([
            'nombre' => ['required', 'string'],
            'descripcion' => ['required', 'string'],
            'img' => ['nullable', 'string', 'regex:/^data:image\/(png|jpeg|jpg|gif);base64,/i'],
            'presentacion' => ['nullable', 'mimes:pdf', 'max:10000'],
            'tipo' => ['required', 'integer'],
            'congreso' => ['nullable', 'integer'],
            'usuario' => ['required', 'integer'],
        ]);

        $imagen = null;
        if (isset($data['img']))
        {
            $urlPublica = null;
            $base64Data = explode(',', $data['img'])[1];
            $decodedData = base64_decode($base64Data);

            $dataImg = getimagesizefromstring($decodedData);

            // Generar un nombre único basado en la fecha actual
            $fechaActual = now();
            $extension = image_type_to_extension($dataImg[2], false); // Obtener la extensión según el tipo de imagen
            $nombreArchivo = $fechaActual->format('YmdHis') . uniqid() . '.' . $extension;
            
            $rutaArchivo = 'public/img/portadas/' . $nombreArchivo;
            // Usando Storage para guardar la imagen en el disco predeterminado
            Storage::put($rutaArchivo, $decodedData);  

            // Obtener la URL pública del archivo
            $urlPublica = Storage::url($rutaArchivo);

            $imagen = $urlPublica;
        }

        $presentacionBd = null;
        if (isset($data['presentacion']))
        {
            $file = $request->file('presentacion');
            $name = $file->getClientOriginalName();
            $fechaActual = now();

            $nombreArchivo = $fechaActual->format('YmdHis') . uniqid() . $name;
            
            $rutaArchivo = 'public/pdf/presentaciones/' . $nombreArchivo;
            $path = Storage::putFileAs(
                'public/pdf/presentaciones/', $file, $nombreArchivo
            );

            // Obtener la URL pública del archivo
            $urlPublica = Storage::url($rutaArchivo);

            $presentacionPdf = ['pdf' => $urlPublica];
            $presentacionBd = $presentacionPdf;
        }

        $congreso = null;
        if (isset($data['congreso']) && $data['congreso'] != 0)
        {
            $congreso = $data['congreso'];
        }
        else if($data['congreso'] == 0)
        {
            $congreso = 0;
        }

        $presentacion->update([
            'nombre' => $data['nombre'],
            'descripcion' => $data['descripcion'],
            'id_tipo_presentacion' => $data['tipo'],
            'id_usuario' => $data['usuario'],
            'img' => $imagen != null ? $imagen : $presentacion->img,
            'presentacion' => $presentacionBd != null ? $presentacionBd : $presentacion->presentacion,
            'id_congreso' => $congreso == 0 ? null : ($congreso != 0 && $congreso != null ? $congreso : $presentacion->id_congreso)
        ]);

        session()->flash('status', 'Presentación actualizada');
        session()->flash('icon', 'success');

        return to_route('admin.presentaciones');
    }

    public function updatePresentacion(presentaciones $presentacion)
    {
        $presentacion->update([
            'presentacion' => null
        ]);
        return to_route('admin.presentaciones.edit', $presentacion);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(presentaciones $presentacion)
    {
        $fechas = fechas::where('id_presentacion', $presentacion->id)->get();
        foreach ($fechas as $fecha) {
            $fecha->delete($fecha);
        }

        $presentacion->delete($presentacion);

        session()->flash('status', 'Presentación eliminada');
        session()->flash('icon', 'info');
        return to_route('admin.presentaciones');
    }
}
