<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\usuarios;
use App\Models\tipo_usuario;
use App\Models\presentaciones;
use App\Models\fechas;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UsuariosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function indexAdmin()
    {
        $tipos_usuario = tipo_usuario::get();
        $usuarios = usuarios::with('tipo_usuario')->get();

        return view('admin.usuarios.index', ['usuarios' => $usuarios, 'tipos_usuario' => $tipos_usuario]);
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
            'matricula' => ['nullable', 'integer', 'unique:usuarios'],
            'correo' => ['required', 'string', 'email', 'unique:usuarios'],
            'password' => ['required', 'string', Password::defaults()],
            'tipo_usuario' => ['required', 'integer'],
            'fb' => ['nullable', 'string', 'regex:/^(https?:\/\/)?(www\.)?facebook\.com\/.+/i'],
            'tw' => ['nullable', 'string', 'regex:/^(https?:\/\/)?(www\.)?twitter\.com\/.+/i'],
            'ig' => ['nullable', 'string', 'regex:/^(https?:\/\/)?(www\.)?instagram\.com\/.+/i'],
            'tk' => ['nullable', 'string', 'regex:/^(https?:\/\/)?(www\.)?tiktok\.com\/.+/i'],
            'img' => ['nullable', 'string', 'regex:/^data:image\/(png|jpeg|jpg|gif);base64,/i'],
        ]);

        $usuario = new usuarios();

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
            
            $rutaArchivo = 'public/img/pfp/' . $nombreArchivo;
            // Usando Storage para guardar la imagen en el disco predeterminado
            Storage::put($rutaArchivo, $decodedData);  

            // Obtener la URL pública del archivo
            $urlPublica = Storage::url($rutaArchivo);

            $usuario->foto_perfil = $urlPublica;
        }

        if (isset($data['fb']) || isset($data['tw']) || isset($data['ig']) || isset($data['tk']))
        {
            $redes_sociales = null;
            if (isset($data['fb']))
            {
                $redes_sociales['fb'] = $data['fb'];
            }

            if (isset($data['tw']))
            {
                $redes_sociales['tw'] = $data['tw'];
            }

            if (isset($data['ig']))
            {
                $redes_sociales['ig'] = $data['ig'];
            }

            if (isset($data['tk']))
            {
                $redes_sociales['tk'] = $data['tk'];
            }

            $usuario->redes_sociales = $redes_sociales;
        }

        $usuario->nombre = $data['nombre'];
        $usuario->matricula = isset($data['matricula']) ? $data['matricula'] : null;
        $usuario->correo = $data['correo'];
        $usuario->password = Hash::make($data['password']);
        $usuario->id_tipo_usuario = $data['tipo_usuario'];
        $usuario->save();

        session()->flash('status', 'Usuario añadido');
        session()->flash('icon', 'success');

        return to_route('admin.usuarios');
    }

    /**
     * Display the specified resource.
     */
    public function show(usuarios $usuario)
    {
        $presentaciones = presentaciones::where('id_usuario', $usuario->id)->get();

        return view('usuarios.index', ['usuario' => $usuario, 'presentaciones' => $presentaciones]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(usuarios $usuario)
    {
        $tipos_usuario = tipo_usuario::get();

        if (auth()->user()->id == $usuario->id)
        {
            // return view('admin.configuracion', ['usuario' => $usuario, 'tipos_usuario' => $tipos_usuario]);
            return to_route('configuracion', ['usuario' => $usuario, 'tipos_usuario' => $tipos_usuario]);
        }

        return view('admin.usuarios.edit', ['usuario' => $usuario, 'tipos_usuario' => $tipos_usuario]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, usuarios $usuario)
    {
        $data = $request->validate([
            'nombre' => ['required', 'string'],
            'matricula' => ['nullable', 'integer', 'unique:usuarios,matricula,' . $usuario->id],
            'correo' => ['required', 'string', 'email', 'unique:usuarios,correo,' . $usuario->id],
            'tipo_usuario' => ['required', 'integer'],
            'fb' => ['nullable', 'string', 'regex:/^(https?:\/\/)?(www\.)?facebook\.com\/.+/i'],
            'tw' => ['nullable', 'string', 'regex:/^(https?:\/\/)?(www\.)?twitter\.com\/.+/i'],
            'ig' => ['nullable', 'string', 'regex:/^(https?:\/\/)?(www\.)?instagram\.com\/.+/i'],
            'tk' => ['nullable', 'string', 'regex:/^(https?:\/\/)?(www\.)?tiktok\.com\/.+/i'],
            'img' => ['nullable', 'string', 'regex:/^data:image\/(png|jpeg|jpg|gif);base64,/i'],
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
            
            $rutaArchivo = 'public/img/pfp/' . $nombreArchivo;
            // Usando Storage para guardar la imagen en el disco predeterminado
            Storage::put($rutaArchivo, $decodedData);  

            // Obtener la URL pública del archivo
            $urlPublica = Storage::url($rutaArchivo);

            $imagen = $urlPublica;
        }

        $redes_sociales = null;
        if (isset($data['fb']))
        {
            $redes_sociales['fb'] = $data['fb'];
        }

        if (isset($data['tw']))
        {
            $redes_sociales['tw'] = $data['tw'];
        }

        if (isset($data['ig']))
        {
            $redes_sociales['ig'] = $data['ig'];
        }

        if (isset($data['tk']))
        {
            $redes_sociales['tk'] = $data['tk'];
        }

        $usuario->update([
            'nombre' => $data['nombre'],
            'matricula' => isset($data['matricula']) ? $data['matricula'] : null,
            'correo' => $data['correo'],
            'foto_perfil' => $imagen != null ? $imagen : $usuario->foto_perfil,
            'redes_sociales' => $redes_sociales != null ? $redes_sociales : $usuario->redes_sociales,
            'id_tipo_usuario' => $data['tipo_usuario'],
        ]);

        session()->flash('status', 'Usuario actualizado');
        session()->flash('icon', 'success');

        return to_route('admin.usuarios');
    }

    public function viewConf()
    {
        $tipos_usuario = tipo_usuario::get();
        $usuario = auth()->user();
        $presentaciones = presentaciones::where('id_usuario', $usuario->id)->get();
        
        return view('admin.configuracion', ['usuario' => $usuario, 'tipos_usuario' => $tipos_usuario, 'presentaciones' => $presentaciones]);
    }

    public function updateConf(Request $request, usuarios $usuario)
    {
        $data = $request->validate([
            'nombre' => ['required', 'string'],
            'matricula' => ['nullable', 'integer', 'unique:usuarios,matricula,' . $usuario->id],
            'correo' => ['required', 'string', 'email', 'unique:usuarios,correo,' . $usuario->id],
            'password' => ['nullable', 'string', Password::defaults()],
            'fb' => ['nullable', 'string', 'regex:/^(https?:\/\/)?(www\.)?facebook\.com\/.+/i'],
            'tw' => ['nullable', 'string', 'regex:/^(https?:\/\/)?(www\.)?twitter\.com\/.+/i'],
            'ig' => ['nullable', 'string', 'regex:/^(https?:\/\/)?(www\.)?instagram\.com\/.+/i'],
            'tk' => ['nullable', 'string', 'regex:/^(https?:\/\/)?(www\.)?tiktok\.com\/.+/i'],
            'img' => ['nullable', 'string', 'regex:/^data:image\/(png|jpeg|jpg|gif);base64,/i'],
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
            
            $rutaArchivo = 'public/img/pfp/' . $nombreArchivo;
            // Usando Storage para guardar la imagen en el disco predeterminado
            Storage::put($rutaArchivo, $decodedData);  

            // Obtener la URL pública del archivo
            $urlPublica = Storage::url($rutaArchivo);

            $imagen = $urlPublica;
        }

        $redes_sociales = null;
        if (isset($data['fb']))
        {
            $redes_sociales['fb'] = $data['fb'];
        }

        if (isset($data['tw']))
        {
            $redes_sociales['tw'] = $data['tw'];
        }

        if (isset($data['ig']))
        {
            $redes_sociales['ig'] = $data['ig'];
        }

        if (isset($data['tk']))
        {
            $redes_sociales['tk'] = $data['tk'];
        }

        $usuario->update([
            'nombre' => $data['nombre'],
            'matricula' => isset($data['matricula']) ? $data['matricula'] : null,
            'correo' => $data['correo'],
            'password' => isset($data['password']) ? Hash::make($data['password']) : $usuario->password,
            'foto_perfil' => $imagen != null ? $imagen : $usuario->foto_perfil,
            'redes_sociales' => $redes_sociales != null ? $redes_sociales : $usuario->redes_sociales,
        ]);

        session()->flash('status', 'Usuario actualizado');
        session()->flash('icon', 'success');

        return to_route('configuracion');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(usuarios $usuario)
    {
        if (auth()->user()->id == $usuario->id)
        {
            // return view('admin.configuracion', ['usuario' => $usuario, 'tipos_usuario' => $tipos_usuario]);
            return to_route('admin.usuarios');
        }

        $presentaciones = presentaciones::where('id_usuario', $usuario->id)->get();
        foreach ($presentaciones as $presentacion) {
            $fechas = fechas::where('id_presentacion', $presentacion->id)->get();
            foreach ($fechas as $fecha) {
                $fecha->delete($fecha);
            }

            $presentacion->delete($presentacion);
        }

        $usuario->delete($usuario);

        session()->flash('status', 'Usuario eliminado');
        session()->flash('icon', 'info');
        return to_route('admin.usuarios');
    }
}
